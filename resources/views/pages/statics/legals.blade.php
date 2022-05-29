@extends('shared.namespaces.static')
@section('page') page-cgu page-legals @stop
@section('title'){{ _i("Mentions légales") }}@stop
@section('description'){{ _i("Mentions légales de %s", [config('app.site_name')]) }}@stop
@section('robots')<meta name="robots" content="NOINDEX" data-reason="legals page">@stop

@section('static_content')

  <div class="container">

    <div class="static-main-heading">
      <h1 class="static-title">@yield('title')</h1>
      <h2 class="static-subtitle">@yield('description')</h2>
    </div>

    <section class="cgu-section">
      <h2 class="cgu-section-title">1. MENTIONS LÉGALES</h2>
      <p>Conformément aux dispositions des articles 6-III et 19 de la loi pour la Confiance dans l'Économie Numérique, voici nos informations légales :</p>

      <p>Le site Internet {{ config('app.url') }} est édité par la SARL MODALOVA, domiciliée au 60 rue François 1er 75008 Paris et enregistrée au RCS de Paris sous le numéro 911 693 976.</p>

      <p>Téléphone : <a href="tel:+33186919996">+33 (0) 1 86 91 99 96</a> (coût d'un appel local, numéro accessible depuis la France métropolitaine).</p>

      <p>E-mail : {{ config('app.email') }}.</p>

      <p>Directeur de la publication : Gabriel Kaam</p>
      <p>Site web hébergé par Heroku San Francisco, Californie, États-Unis</p>
    </section>

    <section class="cgu-section">
      <h2 class="cgu-section-title">2. Informatique et Libertés</h2>
      <p>En application de la loi n°78-17 du 6 janvier 1978 modifiée, relative à l'informatique, aux fichiers et aux libertés, le site web a fait l'objet d'une déclaration auprès de la Commission Nationale de l'Informatique et des Libertés (www.cnil.fr),
      Les traitements automatisés de données nominatives réalisés à partir du site web "{{ config('app.url') }}" ont été traités en conformité avec les exigences de la loi n°78-17 du 6 janvier 1978 modifiée, relative à l'informatique, aux fichiers et aux libertés.<br/>
      L'utilisateur est notamment informé que conformément à l'article 32 de la loi n°78-17 du 6 janvier 1978 modifiée, relative à l'informatique, aux fichiers et aux libertés, les informations qu'il communique par le biais des formulaires présents sur le site sont nécessaires pour répondre à sa demande et sont destinées à la société éditrice du site {{ config('app.url') }}, en tant que responsable du traitement à des fins de gestion administrative et commerciale.<br/>
      L'utilisateur est informé qu'il dispose d'un droit d'accès, d'interrogation et de rectification qui lui permet, le cas échéant, de faire rectifier, compléter, mettre à jour, verrouiller ou effacer les données personnelles le concernant qui sont inexactes, incomplètes, équivoques, périmées ou dont la collecte, l'utilisation, la communication ou la conservation est interdite.<br/>
      L'utilisateur dispose également d'un droit d'opposition au traitement de ses données pour des motifs légitimes ainsi qu'un droit d'opposition à ce que ces données soient utilisées à des fins de prospection commerciale.<br/>
      L'ensemble de ces droits s'exerce par courrier électronique accompagné d'une copie d'un titre d'identité comportant une signature à adresser à {{ config('app.email') }}</p>
    </section>

    <section class="cgu-section">
      <h2 class="cgu-section-title">3. Cookies</h2>
      <p>L'utilisateur est informé que lors de ses visites sur le site, un cookie peut s'installer automatiquement sur son logiciel de navigation.<br/>
      Le cookie est un bloc de données qui ne permet pas d'identifier les utilisateurs mais sert à enregistrer des informations relatives à la navigation de celui-ci sur le site.<br/>
      Le paramétrage du logiciel de navigation permet d'informer de la présence de cookie et éventuellement, de la refuser de la manière décrite à l'adresse suivante : www.cnil.fr.<br/>
      L'utilisateur dispose de l'ensemble des droits susvisés s'agissant des données à caractère personnel communiquées par le biais des cookies dans les conditions indiquées ci-dessus.<br/>
      Les utilisateurs du site internet "{{ config('app.url') }}" sont tenus de respecter les dispositions de la loi n°78-17 du 6 janvier 1978 modifiée, relative à l'informatique, aux fichiers et aux libertés, dont la violation est passible de sanctions pénales.<br/>
      Ils doivent notamment s'abstenir, s'agissant des informations à caractère personnel auxquelles ils accèdent ou pourraient accéder, de toute collecte, de toute utilisation détournée d'une manière générale, de tout acte susceptible de porter atteinte à la vie privée ou à la réputation des personnes.</p>
    </section>

  </div>

@stop
