@if( ! $active_1 ) @php return; @endphp @endif

@if(App\Models\Gender::areMatching($gender, $category->gender))
  @php $klass = '' @endphp

  @if(isset($current_brand))
    @php $white_list = App\Models\WhiteList::getWhiteList($gender, $current_brand, $category) @endphp

    @if( ! $white_list ) @php return; @endphp @endif

    @php $url = $white_list->getRoute() @endphp
    @php $klass .= ' li--white-listed' @endphp
  @else
    @php $url = get_magic_route(array_merge($data, ['gender' => $gender, 'category' => $category])) @endphp
  @endif

  @php $active_2 = $active_1 && (@$current_category && $current_category->isEqualOrChildren($category)) @endphp
  @php $has_children = !$category->isLeaf() @endphp

  @if( $active_2 ) @php $klass .= ' li--active'  @endphp @endif
  @if( !$has_children ) @php $klass .= ' no-after'  @endphp @endif

  <li class="{{ $klass }}">
    <a
      data-category-id="{{ $category->slug }}"
      class="@if( $active_2 ) active @endif @if( !$has_children ) no-after @endif"
      title="{{ clean_for_html(_i("%s %s %s", [
        text_for_seo__category(['category_title' => $category->title]),
        text_for_seo__brand(['brand' => $current_brand]),
        text_for_seo__gender(['gender' => $gender]),
      ])) }}"
      href="{{ $url }}">{{ $category->title }}</a>

    @if( $has_children && $active_2 )<ul>@foreach ($category->children as $child
      )@include('pages.shop.partials.aside._category', [
        'category' => $child,
        'active_1' => $active_2,
        ])@endforeach</ul> @endif
  </li>
@endif
