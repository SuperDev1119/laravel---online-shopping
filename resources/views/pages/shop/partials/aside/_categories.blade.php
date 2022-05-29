@php
  $default_gender_active = App\Models\Gender::GENDER_BOTH;

  // Prevent 'color' from being used in get_magic_route()
  $keep_color = @$data['color'];
  unset($data['color']);

  $data['categories'] = @$data['categories'] ?: get_categories_as_tree();
@endphp

<div class="aside-section categories-section filter--section filter--section--no-shadow">
  <div class="filter--section--header">
    <span class="aside-section-close filters--section--close">
      <div>
        <span class="aside-section-label">{{ _i('Catégories') }}</span>
      </div>
    </span>
  </div>

  <ul class="aside-section-content nested-list filter--section--body">
    @foreach(App\Models\Gender::GENDERS as $gender)
      @if(isset($current_brand))
        @php
        $gender_of_brand = $current_brand->gender;
        if ( $gender_of_brand && App\Models\Gender::GENDER_BOTH != $gender_of_brand ) {
          if ( $gender_of_brand != $gender )
            continue;

          $default_gender_active = $current_brand->gender;
        }
        @endphp
      @endif
      @php $active_1 = isset($current_gender) ? $current_gender == $gender : $default_gender_active == $gender @endphp

      <li class="@if( $active_1 ) li--active @endif">
        <a
          class="categories @if( $active_1 ) active @endif"
          href="{{ get_magic_route(array_merge($data, ['gender' => $gender, 'category' => null])) }}"
          >{{ ucfirst(_i($gender)) }}</a>

        <ul class="@if( ! $active_1 ) close-sidebar @endif">
          @foreach($data['categories'] as $category)
            @include('pages.shop.partials.aside._category', [
              'category' => $category,
              'active_1' => $active_1,
              ])
            @endforeach
        </ul>

      </li>
    @endforeach
  </ul>
</div>

@php
  if(!empty($keep_color))
    $data['color'] = $keep_color;
@endphp
