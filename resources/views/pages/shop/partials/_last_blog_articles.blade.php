<div class="box-home box-home--magazine container">
  <h2 class="text-center">{{ _i("Derniers articles") }}</h2>

  <div class="box--content">
    @foreach($data['blog_articles'] as $blog_article)
      <div class="card">
        <div class="card-image">
          <a
            class="img"
            href="{{ $blog_article['link'] }}" target="_blank"
            title="{{ $blog_article['title']['rendered'] }}"
            style="background-image: url({{
              (
                @$blog_article['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['large']
                ?: $blog_article['_embedded']['wp:featuredmedia'][0]['media_details']['sizes']['full']
              )['source_url'] }})"></a>
        </div>

        <div class="card-body text-center">
          <div>
            <h3><a href="{{ $blog_article['link'] }}" target="_blank">{!! clean_for_html($blog_article['title']['rendered']) !!}</a></h3>
            <p class="card-text">{!! clean_for_html($blog_article['excerpt']['rendered']) !!}</p>
            <a href="{{ $blog_article['link'] }}" target="_blank" title="{{ $blog_article['title']['rendered'] }}">{{ _i("Lire l'article") }} &gt;</a>
          </div>
        </div>
      </div>
    @endforeach

    <div class="text-center" style="margin: 2em">
      <a href="{{ url('/zine/') }}" class="btn btn-black" target="_blank">{{ _i('Lire tous les articles') }}</a>
    </div>
  </div>
</div>
