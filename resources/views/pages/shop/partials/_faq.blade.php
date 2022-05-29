@php $faq_items = App\Models\FaqItem::ordered()->get() @endphp

<script type="application/ld+json">
  {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(function($faq_item) {
      return [
        '@type' => 'Question',
        'name' => $faq_item['question'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $faq_item['answer'],
        ],
      ];
    }, $faq_items->toArray())
  ]) !!}
</script>

<ul class="faq">
  @foreach($faq_items as $faq_item)
    <li class="faq-item">
      <div class="faq-item-issue">{{ $faq_item->question }}</div>
      <div class="faq-item-content">{!! $faq_item->answer !!}</div>
    </li>
  @endforeach
</ul>
