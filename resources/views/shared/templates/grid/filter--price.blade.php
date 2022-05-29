<script type="text/html" id="grid--filter--price-template">
  <div class="ais-root ais-refinement-list filter--section">
    <div class="ais-refinement-list--header ais-header filter--section--header">
      <span class="filters--section--close">
        <div>
          <span class="filters--section--label">@{{ header }}</span>
        </div>
      </span>
    </div>

    <div class="ais-body ais-refinement-list--body filter--section--body">
      <div>
        <form class="ais-price-ranges--form">
          <input name="filter-price-min" type="hidden" />
          <input name="filter-price-max" type="hidden" />
          <input name="filter-promotion" type="hidden" />

          <div>
            <label class="ais-price-ranges--label">
              <input
                type="number"
                name="temp-price-min"
                class="ais-price-ranges--input"
                placeholder="{{ _i('Min.') }}" />
            </label>
            <span class="ais-price-ranges--separator">{{ _i('à') }}</span>
            <label class="ais-price-ranges--label">
              <input
                type="number"
                name="temp-price-max"
                class="ais-price-ranges--input"
                placeholder="{{ _i('Max.') }}" />
            </label>
          </div>

          @if(true !== @$data['promotion'])
            <div>
              <label class="ais-price-checkbox--label">
                @if(0 < @$data['aggs']['reduction_max']['value'])
                  <input
                    type="checkbox"
                    name="temp-promotion"
                    class="ais-price-checkbox--input" />
                  {{ _i('Uniquement les produits en promotion') }} ?
                @else
                  <i style="font-style: italic">{{ _i('Aucune promotion en cours sur cette page.') }}</i>
                @endif
              </label>
            </div>
          @endif

          <button type="submit">{{ _i('Filtrer!') }}</button>
        </form>
      </div>
    </div>
  </div>

</script>
