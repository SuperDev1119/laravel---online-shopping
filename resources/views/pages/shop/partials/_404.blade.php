<div class="products-grid-empty">
  <img src="{{ asset('images/no_results.jpg', is_connection_secure()) }}" alt="">

  <div class="products-grid-empty__content">
    <div>
      <h1>{{ _i("Désolé.\nLa page que vous cherchez n'existe pas.") }}</h1>
      <a href="{{ route('home') }}" class="btn btn-black">{{ _i("Revenir à mon shopping") }}</a>
    </div>
  </div>
</div>
