<?php
// criar "hamburger menu" 
// deixar mais bonito
//add a logo
// fazer a logo voltar para o index.php
// melhorar desempenho
// add icone contato
// add icone carrinho
// fazer animacao
function navbar($paginaAtiva = '')
{
    echo '
    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        .navbar {
          background-color: #262f47;
          color: white;
          width: 100%;
          position: sticky;
          top: 0;
          z-index: 1000;
          box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .navbar-container {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 0.8rem 1.5rem;
          max-width: 1200px;
          margin: 0 auto;
        }

        .logo a {
          color: #ff8001;
          font-size: 1.5rem;
          font-weight: bold;
          text-decoration: none;
          letter-spacing: 1px;
        }

        .nav-links {
          list-style: none;
          display: flex;
          gap: 1.5rem;
        }

        .nav-links a {
          color: white;
          text-decoration: none;
          font-size: 1rem;
          transition: color 0.3s;
        }

        .nav-links a:hover {
          color: #ff8001;
        }

        .nav-links .ativo {
          color: #ff8001;
          border-bottom: 2px solid #ff8001;
        }

        .menu-toggle {
          display: none;
          flex-direction: column;
          cursor: pointer;
        }

        .menu-toggle span {
          height: 3px;
          width: 25px;
          background: white;
          margin: 4px 0;
          border-radius: 5px;
        }

        @media (max-width: 768px) {
          .nav-links {
            display: none;
            flex-direction: column;
            width: 100%;
            background: #d37212ff;
            text-align: center;
          }

          .nav-links.active {
            display: flex;
          }

          .menu-toggle {
            display: flex;
          }
        }
    </style>

    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <a href="index.html">LUMI</a>
            </div>

            <div class="menu-toggle" id="menu-toggle">
                <span></span><span></span><span></span>
            </div>

            <ul class="nav-links" id="nav-links">
                <li><a href="roupas.php" ' . ($paginaAtiva == "roupas" ? 'class="ativo"' : '') . '>Roupas</a></li>
                <li><a href="acessorios.php" ' . ($paginaAtiva == "acessorios" ? 'class="ativo"' : '') . '>Acessórios</a></li>
                <li><a href="naosei.php" ' . ($paginaAtiva == "naosei" ? 'class="ativo"' : '') . '>Lançamentos</a></li>
                <li><a href="contato.php" ' . ($paginaAtiva == "contato" ? 'class="ativo"' : '') . '>Contato</a></li>
            </ul>
        </div>
    </nav>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.getElementById("menu-toggle");
        const navLinks = document.getElementById("nav-links");

        if (menuToggle && navLinks) {
            menuToggle.addEventListener("click", function() {
                navLinks.classList.toggle("active");
                menuToggle.classList.toggle("open");
            });
        }
    });
    </script>
    ';
}
