<?= $this->extend('layout/layout_default') ?>
<?= $this->section('conteudo') ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin-top: 90px;
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f9f9f9;
    }


    section {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    section h2 {
        color: #004080;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }

    section p {
        margin-bottom: 15px;
        font-size: 1rem;
        color: #555;
    }

    section ul {
        list-style-type: none;
        padding: 0;
    }

    section ul li {
        margin-bottom: 10px;
        padding-left: 20px;
        position: relative;
    }

    section ul li::before {
        content: "•";
        color: #004080;
        font-weight: bold;
        font-size: 1.5rem;
        position: absolute;
        left: 0;
    }

    .contato p {
        font-size: 1rem;
        color: #333;
    }




    @media (max-width: 768px) {
        header h1 {
            font-size: 1.5rem;
        }

        section {
            margin: 10px;
            padding: 15px;
        }

        section h2 {
            font-size: 1.25rem;
        }

        footer {
            font-size: 0.8rem;
        }
    }
</style>

<body>

<section class="SobreNos">
    <h2>Quem Somos</h2>
    <p>Somos uma startup, e temos a missão de oferecer soluções eficientes para a gestão pública. Com uma equipe dedicada, especializada e disposta.</p>
</section>

<section class="Missao">
    <h2>Nossa Missão</h2>
    <p>Nosso objetivo é proporcionar sistemas gerenciais que contribuam para uma administração pública mais eficiente e conectada. Entendemos as demandas das prefeituras e desenvolvemos ferramentas personalizadas que tornam os processos internos mais ágeis e organizados.</p>
</section>


<section class="Contato">
    <h2>Entre em Contato</h2>
    <p>Para saber mais sobre nossos serviços ou para agendar uma demonstração, entre em contato conosco.</p>
    <p>Email: controleEstoque@gmail.com</p>
</section>


</body>

<?= $this->endSection() ?>