@extends('welcome')
@section('title')
    Sobre - SUPREMA
@endsection

@section('content')


    <!-- Seção Hero com Imagem de fundo e Card sobreposto -->
    <div class="sobre-hero">
        <img src="{{ asset('uploads/sobre.avif') }}" alt="Ambiente Suprema Home and Garden">

        <div class="sobre-card-overlay">
            <div class="sobre-card-content">
                <h2>Olá, somos a Suprema<br>Home and Garden</h2>
                <p>
                    Aqui buscamos ir além do convencional, desafiando limites e criando móveis exclusivos que atendem tanto à estética quanto à necessidade de praticidade. Acreditamos que cada peça que produzimos não é apenas um móvel, mas uma extensão da personalidade de quem o utiliza.
                </p>
            </div>
        </div>
    </div>

    <!-- Conteúdo de Texto -->
    <div class="sobre-content">
        <div class="sobre-text-content">
            <p>A Suprema Home and Garden nasceu da paixão por criar espaços que unissem funcionalidade, beleza e aconchego. Fundada em 2022, buscamos ir além do convencional, desafiando limites e criando móveis exclusivos que atendem tanto à estética quanto à necessidade de praticidade.</p>

            <p>Acreditamos que cada peça que produzimos não é apenas um móvel, mas uma extensão da personalidade de quem o utiliza. Nossa missão é proporcionar conforto e estilo, através de produtos de alta qualidade, durabilidade e design inovador.</p>

            <p>Com o tempo, a Suprema Home and Garden foi se expandindo e incorporando novas tecnologias e tendências, mantendo, no entanto, sua essência artesanal e o compromisso com o atendimento dedicado e personalizado. Nossa equipe de designers, artesãos e técnicos trabalha em conjunto para criar soluções completas, que transformam qualquer espaço em um ambiente único.</p>

            <p>Hoje, somos uma referência no mercado de móveis, reconhecidos pela qualidade dos nossos produtos e pela experiência excepcional que oferecemos aos nossos clientes. Nos orgulhamos de ser parceiros na criação de ambientes que atendem às necessidades e ao estilo de cada cliente, seja no lar, no escritório ou em outros espaços comerciais.</p>

            <p>Nosso compromisso continua a ser o mesmo: criar móveis que fazem a diferença, que inspiram e que proporcionam a sensação de bem-estar, seja no simples cotidiano ou em momentos especiais. A Suprema Home and Garden é mais do que uma marca, é uma história de dedicação, inovação e respeito pela arte de fazer móveis que duram para toda a vida.</p>

            <p>Convidamos você a conhecer o nosso trabalho e transformar seus ambientes com peças que são, de fato, feitas para você.</p>
        </div>
    </div>
@endsection
