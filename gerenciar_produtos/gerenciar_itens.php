<?php
// front end

// quando incluir o item, agora preciso por o nome, o preço, a quantidade em estoque e a imagem
// fazer o mesmo quando modificar o item
require '../templates/header.php';
require '../navbar.php';
navbar('home');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Itens</title>
</head>

<body>
    <div class="main-container">
        <div class="easyui-panel" title="Gerenciamento de Itens" style="padding:10px;">
            <div style="margin-bottom:10px;">
                <a onclick="abrirDialogInclusaoItem()" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Incluir Item</a>
                <!-- <a href="gerenciar_pedidos.php" class="easyui-linkbutton" data-options="iconCls:'icon-undo'">Voltar para Pedidos</a> -->
            </div>
            <table id="dg_itens" style="width:100%; height:400px"></table>
        </div>
    </div>

    <div id="dlg-item" class="easyui-dialog" style="width:550px; padding: 10px 20px;" closed="true" modal="true" buttons="#dlg-item-buttons"></div>

    <div id="dlg-item-buttons">
        <a class="easyui-linkbutton" iconCls="icon-ok" onclick="salvarItem()" style="width:90px">Salvar</a>
        <a class="easyui-linkbutton" iconCls="icon-cancel" onclick="$('#dlg-item').dialog('close')" style="width:90px">Cancelar</a>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#dg_itens').datagrid({
            url: 'listar_dados_json.php',
            method: 'post',
            queryParams: {
                tipo: 'itens'
            },
            pagination: true,
            striped: true,
            scrollbarSize: 0,
            fitColumns: true,
            singleSelect: true,
            columns: [
                [{
                        field: 'cod_item',
                        title: 'Código',
                        width: 80,
                        align: 'center'
                    },
                    {
                        field: 'den_item',
                        title: 'Descrição do Item',
                        width: 300
                    },
                    {
                        field: 'preco_item',
                        title: 'Preço',
                        width: 100,
                    },
                    {
                        field: 'qtd_estoque',
                        title: 'Quantidade',
                        width: 100,
                    },
                    {
                        field: 'action',
                        title: 'Ações',
                        width: 150,
                        align: 'center',
                        formatter: formatActionItem
                    }
                ]
            ],

            // Callback executado após o carregamento dos dados
            onLoadSuccess: function() {
                // Renderiza os botões de ação (Modificar/Excluir) dentro do datagrid
                $('#dg_itens').datagrid('getPanel').find('.easyui-linkbutton').linkbutton();
            },
        });
    });

    // Dialogs
    function abrirDialogInclusaoItem() {
        $('#dlg-item').dialog('open').dialog('setTitle', 'Incluir Novo Item');
        $('#dlg-item').load('controlar_item.php?form_only=1', function() {
            $.parser.parse('#dlg-item');
        });
    }

    function abrirDialogModificacaoItem(cod_item) {
        $('#dlg-item').dialog('open').dialog('setTitle', 'Modificar Item');
        $('#dlg-item').load('controlar_item.php?form_only=1&cod_item=' + cod_item, function() {
            $.parser.parse('#dlg-item');
        });
    }

    // Botão Salvar
    function salvarItem() {
        var form = $('#fm-item');
        if (!form.form('validate')) return;
        $.ajax({
            url: 'controlar_item.php',
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $('#dlg-item').dialog('close');
                    $('#dg_itens').datagrid('reload');
                    $.messager.show({
                        title: 'Sucesso',
                        msg: 'Item salvo com sucesso.'
                    });
                } else $.messager.alert('Erro', result.message, 'error');
            },
            error: function() {
                $.messager.alert('Erro Crítico', 'Não foi possível contatar o servidor.', 'error');
            }
        });
    }

    // Botão Excluir
    function excluirItem(cod_item) {
        $.messager.confirm('Confirmar Exclusão', 'Tem certeza que deseja excluir este item?', function(r) {
            if (r) {
                $.ajax({
                    url: 'excluir_item.php',
                    type: 'post',
                    data: {
                        cod_item: cod_item
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.success) {
                            $('#dg_itens').datagrid('reload');
                            $.messager.show({
                                title: 'Sucesso',
                                msg: result.message
                            });
                        } else $.messager.alert('Erro na Exclusão', result.message, 'error');
                    },
                    error: function() {
                        $.messager.alert('Erro Crítico', 'Não foi possível contatar o servidor para exclusão.', 'error');
                    }
                });
            }
        });
    }

    // Formatação da coluna Ações
    function formatActionItem(value, row) {
        var btnModificar = '<a class="easyui-linkbutton" data-options="iconCls:\'icon-edit\',plain:true" onclick="abrirDialogModificacaoItem(' + row.cod_item + ')">Modificar</a>';
        var btnExcluir = '<a class="easyui-linkbutton" data-options="iconCls:\'icon-remove\',plain:true" onclick="excluirItem(' + row.cod_item + ')">Excluir</a>';
        return btnModificar + ' ' + btnExcluir;
    }
</script>

<?php require '../templates/footer.php'; ?>