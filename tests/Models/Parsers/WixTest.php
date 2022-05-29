<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Wix;

class WixTest extends \Tests\Models\SourceTest
{
    public static $klass = Wix::class;

    public static $headers = 'id,title,description,link,image_link,additional_image_link,price,availability,inventory,size,condition,gender,color,age_group,item_group_id,google_product_category,product_type,sale_price,sale_price_effective_date,gtin,brand,mpn,shipping,material';

    public function test__parse_row__from_PanameAndCo()
    {
        // given
        $headers = self::$headers;

        $payload = 'WyIxMDAyZGU3ZS04Njg1LTk1NTYtZjgxMi1lZDUyMTJhNTFiZjUiLCJMZSBQYW5hbWEgZCdFcXVhdGV1ciIsIlR1IGVzIHN1ciBsZSBwb2ludCBkZSBjcmFxdWVyIHBvdXIgdW4gZGUgbm9zIHZcdTAwZTlyaXRhYmxlcyBQYW5hbWFzIGRcdTIwMTlcdTAwYzlxdWF0ZXVyID8gRlx1MDBlOWxpY2l0YXRpb25zICEgU2FjaGUgcXVlIHR1IG5lIGxlIHJlZ3JldHRlcmFzIHBhcyA6IGNcdTIwMTllc3QgdW4gbWFnbmlmaXF1ZSBjb3V2cmUtY2hlZiwgZXh0clx1MDBlYW1lbWVudCBhZ3JcdTAwZTlhYmxlIFx1MDBlMCBwb3J0ZXIgcGFyIHRvdXMsIGhvbW1lIG91IGZlbW1lLiBcdTAwYzlsXHUwMGU5Z2FudCwgaWwgb2ZmcmUgXHUwMGU5Z2FsZW1lbnQgdW5lIGVmZmljYWNlIHByb3RlY3Rpb24gY29udHJlIGxlcyByYXlvbnMgZHUgc29sZWlsLiBJbCBuXHUwMGU5Y2Vzc2l0ZSB0b3V0ZWZvaXMgcXVlbHF1ZXMgcHJcdTAwZTljYXV0aW9ucyBwb3VyIGxlIHByXHUwMGU5c2VydmVyIGxlIHBsdXMgbG9uZ3RlbXBzIHBvc3NpYmxlLiBSZXRyb3V2ZSB0b3VzIG5vcyBjb25zZWlscyBzdXIgbGUgc2l0ZSAhIFRvdXMgbm9zIHBhbmFtYXMgc29udCBmaW5lbWVudCB0cmVzc1x1MDBlOXMgXHUwMGUwIGxhIG1haW4gZW4gXHUwMGM5cXVhdGV1ciBkYW5zIHVuZSBjb29wXHUwMGU5cmF0aXZlIGRlIE1vbnRlY3Jpc3RpLiBMZXMgbWFcdTAwZWV0cmVzIGFydGlzYW5zIGxlcyB0aXNzZW50IFx1MDBlMCBwYXJ0aXIgZGUgZmlicmVzIG5hdHVyZWxsZXMgZGUgcGFsbWVzLCBcdTAwZTlnYWxlbWVudCBjb25udWVzIHNvdXMgbGUgbm9tIGRlIFBhamEgVG9xdWlsbGEuIExhIHBhaWxsZSBlc3QgY3VlaWxsaWUsIHJhZmZpblx1MDBlOWUsIGN1aXRlLCBmdW1cdTAwZTllLCBsYXZcdTAwZTllLCBzXHUwMGU5Y2hcdTAwZTllIGV0IHRyZXNzXHUwMGU5ZSBjb21tZSBsZSBmYWlzYWllbnQgbGV1cnMgYW5jXHUwMGVhdHJlcyBkZXB1aXMgcXVhdHJlIGdcdTAwZTluXHUwMGU5cmF0aW9ucy4gTGEgY291bGV1ciBkZSBsYSBwYWlsbGUgcGV1dCB2YXJpZXIgc2Vsb24gbGVzIGJyaW5zIHV0aWxpc1x1MDBlOXMuIERlIG1hbmlcdTAwZThyZSBnXHUwMGU5blx1MDBlOXJhbGUsIG5vcyBwYW5hbWFzIHNvbnQgcGx1dFx1MDBmNHQgXHUwMGU5Y3J1cyBvdSBuYXR1cmVscy4gUG91ciBjaG9pc2lyIHRvbiBjaGFwZWF1LCBpbCBlc3QgaW1wXHUwMGU5cmF0aWYgZGUgYmllbiBjb25uYVx1MDBlZXRyZSB0b24gdG91ciBkZSB0XHUwMGVhdGUgISBBc3R1Y2UgcG91ciBsZSBtZXN1cmVyIDogSmUgcG9zaXRpb25uZSB1bmUgZmljZWxsZSBvdSB1biBtXHUwMGU4dHJlIHJ1YmFuIGF1IG1pbGlldSBkdSBmcm9udCwgamUgcGFzc2UgcGFyIGxlIGhhdXQgZFx1MjAxOXVuZSBvcmVpbGxlIGV0IGxhIGJvc3NlIGFycmlcdTAwZThyZSBkZSBsYSB0XHUwMGVhdGUsIGplIHJlam9pbnMgZW5zdWl0ZSBsXHUyMDE5YXV0cmUgb3JlaWxsZSwgcG91ciBlbmZpbiByZXZlbmlyIGF1IHBvaW50IGRlIGRcdTAwZTlwYXJ0LiBKZSBjb25uYWlzIG1haW50ZW5hbnQgbW9uIHRvdXIgZGUgdFx1MDBlYXRlICEgXHVkODNkXHVkYzQ5IE5vdXMgZm91cm5pc3NvbnMgZGVzIHJcdTAwZTlkdWN0ZXVycyBlbiBtb3Vzc2UgcXVpIHBlcm1ldHRlbnQgZFx1MjAxOWFqdXN0ZXIgbGEgdGFpbGxlLiBcdWQ4M2NcdWRmODEgTGUgQ2FkZWF1IGRlIE1hcmluZSA6IExlIHRvdGUgYmFnIFBhbmFtZXMgYW5kIENvIGVzdCBvZmZlcnQgcG91ciBsJ2FjaGF0IGQndW4gY2hhcGVhdS4iLCJodHRwczpcL1wvd3d3LnBhbmFtZXNhbmRjby5mclwvcHJvZHVjdC1wYWdlXC9wYW5hbWEtZC1lcXVhdGV1ci1uYXR1cmVsIiwiaHR0cHM6XC9cL3N0YXRpYy53aXhzdGF0aWMuY29tXC9tZWRpYVwvZGJkNzI1XzVlZjg1YzY4ODlhMDRiZmRhMDg5YjdiNjNhYmEzMTY0fm12Mi5qcGdcL3YxXC9maXRcL3dfMTAyNCxoXzEwMjQscV84NSx1c21fMC42Nl8xLjAwXzAuMDFcL2ZpbGUuanBnIiwiaHR0cHM6XC9cL3N0YXRpYy53aXhzdGF0aWMuY29tXC9tZWRpYVwvZGJkNzI1XzQ4ZjU5Zjk2YjU0NjQyYWNiNGY0NjM2NGFiODM3OGEwfm12Mi5qcGdcL3YxXC9maXRcL3dfMTAyNCxoXzEwMjQscV84NSx1c21fMC42Nl8xLjAwXzAuMDFcL2ZpbGUuanBnLGh0dHBzOlwvXC9zdGF0aWMud2l4c3RhdGljLmNvbVwvbWVkaWFcL2RiZDcyNV85ZGNlN2E5ZTFjNzc0MzQ5ODVkZmFjMzFhZjgzNzYzNX5tdjIuanBnXC92MVwvZml0XC93XzEwMjQsaF8xMDI0LHFfODUsdXNtXzAuNjZfMS4wMF8wLjAxXC9maWxlLmpwZyxodHRwczpcL1wvc3RhdGljLndpeHN0YXRpYy5jb21cL21lZGlhXC9kYmQ3MjVfODg5YjRmNTRmOGNkNGI1MGJhZDAyNjJlMjg0ODExNmR+bXYyLmpwZ1wvdjFcL2ZpdFwvd18xMDI0LGhfMTAyNCxxXzg1LHVzbV8wLjY2XzEuMDBfMC4wMVwvZmlsZS5qcGcsaHR0cHM6XC9cL3N0YXRpYy53aXhzdGF0aWMuY29tXC9tZWRpYVwvZGJkNzI1XzVkZDZkOThhODc1ZjQxYjNhYzQ0ZTk3NTU5M2M0YTM2fm12Mi5qcGdcL3YxXC9maXRcL3dfMTAyNCxoXzEwMjQscV84NSx1c21fMC42Nl8xLjAwXzAuMDFcL2ZpbGUuanBnIiwiMTcwLjAgRVVSIiwiaW4gc3RvY2siLCIxMSIsIiIsIm5ldyIsIiIsIiIsIiIsIiIsIiIsIiIsIiIsIiIsIiIsIiIsIjE1ODU5MDI5ODc1MTQwMDAiLCIiLCIiXQ==';

        $expected_value = [
            'name' => 'Le Panama d\'Equateur',
            'slug' => 'le-panama-d-equateur-1002de7e-8685-9556-f812-ed5212a51bf5',
            'description' => 'Tu es sur le point de craquer pour un de nos véritables Panamas d’Équateur ? Félicitations ! Sache que tu ne le regretteras pas : c’est un magnifique couvre-chef, extrêmement agréable à porter par tous, homme ou femme. Élégant, il offre également une efficace protection contre les rayons du soleil. Il nécessite toutefois quelques précautions pour le préserver le plus longtemps possible. Retrouve tous nos conseils sur le site ! Tous nos panamas sont finement tressés à la main en Équateur dans une coopérative de Montecristi. Les maîtres artisans les tissent à partir de fibres naturelles de palmes, également connues sous le nom de Paja Toquilla. La paille est cueillie, raffinée, cuite, fumée, lavée, séchée et tressée comme le faisaient leurs ancêtres depuis quatre générations. La couleur de la paille peut varier selon les brins utilisés. De manière générale, nos panamas sont plutôt écrus ou naturels. Pour choisir ton chapeau, il est impératif de bien connaître ton tour de tête ! Astuce pour le mesurer : Je positionne une ficelle ou un mètre ruban au milieu du front, je passe par le haut d’une oreille et la bosse arrière de la tête, je rejoins ensuite l’autre oreille, pour enfin revenir au point de départ. Je connais maintenant mon tour de tête ! 👉 Nous fournissons des réducteurs en mousse qui permettent d’ajuster la taille. 🎁 Le Cadeau de Marine : Le tote bag Panames and Co est offert pour l\'achat d\'un chapeau.',
            'brand_original' => 'Source Title',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => '',
            'color_original' => '',
            'price' => 170.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://www.panamesandco.fr/product-page/panama-d-equateur-naturel',
            'image_url' => 'https://static.wixstatic.com/media/dbd725_5ef85c6889a04bfda089b7b63aba3164~mv2.jpg/v1/fit/w_1024,h_1024,q_85,usm_0.66_1.00_0.01/file.jpg',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }
}
