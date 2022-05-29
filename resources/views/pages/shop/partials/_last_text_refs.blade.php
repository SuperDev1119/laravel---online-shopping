@php $text_refs = App\Models\TextRef::orderBy('created_at', 'desc')->limit(40)->get() @endphp

@if($text_refs->isNotEmpty())
  <div class="box-home box-home--linking box-home--linking--text-ref container">
    <h2 class="text-center">{{ _i("À re-découvrir") }}</h2>
    <div class="box-home--linking--content">
      <div class="row">
        @foreach($text_refs as $text_ref)
          <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{ url($text_ref->url) }}">{{ get_human_readable_url($text_ref->url) }}</a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endif
