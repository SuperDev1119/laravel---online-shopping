<div class="aside-section aside-section-associated-searches filter--section filter--section--no-shadow">
  <div class="filter--section--header">
    <span class="aside-section-close filters--section--close">
      <div>
        <span class="aside-section-label">{{ _i('À voir aussi') }}</span>
      </div>
    </span>
  </div>

  <ul class="aside-section-content filter--section--body">
    @if( $current_brand )

      @if( $current_category )

        @php $level = $current_category->depth @endphp
        @php $level_max = App\Models\Category::max('depth') @endphp
        @php $level_to_get = (1 == $level) ? $level_max : $level @endphp

        {{-- CAS 2 & 3 & 4 --}}

        @foreach(
          App\Models\WhiteList::where('gender', $current_gender ?: App\Models\Gender::GENDER_BOTH)
            ->with(['brand', 'category'])
            ->whereHas('category', function($q) use ($level_to_get) {
              return $q->where('depth', $level_to_get);
            })
            ->take(10)
            ->inRandomOrder()
            ->get() as $white_list)

          <li><a href="{{ $white_list->getRoute() }}">{{ $white_list }}</a></li>

        @endforeach

      @else

        {{-- CAS 1 --}}

        @foreach([App\Models\Gender::GENDER_FEMALE, App\Models\Gender::GENDER_MALE] as $gender)
          @foreach(
            App\Models\WhiteList::where('gender', $current_gender ?: $gender)
              ->with(['brand', 'category'])
              ->whereHas('category', function($q) {
                return $q->where('depth', 2);
              })
              ->take(5)
              ->inRandomOrder()
              ->get() as $white_list)

            <li><a href="{{ $white_list->getRoute() }}">{{ $white_list }}</a></li>

          @endforeach
        @endforeach

      @endif

    @else

      @php $level = $current_category ? $current_category->depth : 1 @endphp

      @if( 1 == $level )

        {{-- CAS 5 & 6 --}}

        @php $categories_random = App\Models\Category::where('depth', 3)
          ->whereIn('gender', [App\Models\Gender::GENDER_BOTH, $current_gender]) @endphp

        @foreach($categories_random->inRandomOrder()->take(10)->get() as $category)
          <li><a href="{{ get_magic_route([
            'gender' => $current_gender,
            'category' => $category,
            'promotion' => $current_promotion
            ]) }}">{{ trim($category->title . ' ' . ucfirst($current_gender) . ' ' . ($current_promotion ? _i('en Promo') : '')) }}</a></li>
        @endforeach

      @else
        <script type="text/javascript">
          document.getElementsByClassName("aside-section-associated-searches")[0].classList.add('hidden');
        </script>
      @endif

    @endif
  </ul>
</div>
