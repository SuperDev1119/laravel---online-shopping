<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Tradedoubler;

class TradedoublerTest extends \Tests\Models\SourceTest
{
    public static $klass = Tradedoubler::class;

    public static $headers = 'name,productImage,description,categories,fields,weight,size,model,brand,manufacturer,techSpecs,shortDescription,promoText,ean,upc,isbn,mpn,sku,feedId,productUrl,priceValue,priceCurrency,modified,dateFormat,inStock,availability,deliveryTime,sourceProduct
Id,warranty,condition,programLogo,programName,shippingCost,id';

    public function test__parse_row__from_Newchic_Homme()
    {
        // given
        $payload = 'WyJTbGlwIE1lbnMgTXVsdGkgQ29sb3IgQmxvY2sgQ2FzdWFsIENoZW1pc2VzIHJlc3BpcmFudGVzIFx1MDBlMCBtYW5jaGVzIGxvbmd1ZXMiLCJodHRwczpcL1wvaW1nLmJhbmdnb29kLmNvbVwvaW1hZ2VzXC9vYXVwbG9hZFwvc2VyMVwvbmV3Y2hpY1wvaW1hZ2VzXC9FN1wvOUNcLzA2ZTRlNDVlLTA1ZmQtNGI4Yi05NTc3LTRiNjEyN2ZjNDhkNy5qcGc6OiIsIlNwXHUwMGU5Y2lmaWNhdGlvbiA6Q291bGV1cjogQmxldSxyb3VnZVRhaWxsZTogTSxMLFhMLDJYTCwzWExNYXRcdTAwZTlyaWVsOiBQb2x5ZXN0ZXJTdHlsZSAob2NjYXNpb24pOiBNb2RlLERcdTAwZTljb250cmFjdFx1MDBlOWUsdG91cyBsZXMgam91cnNNb2RcdTAwZThsZTogQmxvYyBkZSBjb3VsZXVyTWFycXVlOiBDaEFybWtwUk1hbmNoZTogXHUwMGEwTWFuY2hlIGxvbmd1ZVR5cGUgZCYjMzk7YWp1c3RlbWVudDogRW4gdnJhY1N0eWxlOiBEXHUwMGU5Y29udHJhY3RcdTAwZTllXHUwMGM5cGFpc3NldXI6IE9yZGluYWlyZUxvbmd1ZXVyOiBPcmRpbmFpcmVEXHUwMGU5Y29yYXRpb25zOiBQb2NoZSxcdTAwYTBCb3V0b25zU2Fpc29uOiBcdTAwYTBcdTAwYzl0XHUwMGU5LFRvbWJlclR5cGUgZGUgZmVybWV0dXJlOiBCb3V0b25Db2xsaWVyOiBcdTAwYTBDb2xsaWVyIGRlIGRlc2NlbnRlRW1iYWxsYWdlIGluY2x1czoxICogY2hlbWlzZU5vdGV6IHMmIzM5O2lsIHZvdXMgcGxhXHUwMGVldDoxLlZldWlsbGV6IGNvbnN1bHRlciBsYSByXHUwMGU5Zlx1MDBlOXJlbmNlIGRlIHRhaWxsZSBwb3VyIHRyb3V2ZXIgbGEgdGFpbGxlIGNvcnJlY3RlLiIsIk1lbiA+IENIRU1JU0VTID4gTG9uZyBTbGVldmUgU2hpcnQ7OyIsIiIsIiIsIiIsIiIsIk5ld2NoaWMiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCJTS1VDOTEwNzAiLCIyODA4NSIsImh0dHBzOlwvXC9wZHQudHJhZGVkb3VibGVyLmNvbVwvY2xpY2s/YSgzMTMzNjMyKXAoMjgzNjgwKXByb2R1Y3QoNGE2NGY3NGUtNDU5Zi00NzIwLTk0NmQtMjdjNTVkZDM2ZTA5KXR0aWQoMyl1cmwoaHR0cHMlM0ElMkYlMkZ3d3cubmV3Y2hpYy5jb20lMkZmciUyRmxvbmctc2xlZXZlLXNoaXJ0cy05MTQ3JTJGcC0xNTQxMjA3Lmh0bWwpIiwiMTguNTEiLCJFVVIiLCIxNTc3OTI4NzQ3MzI1IiwiRVBPQ0giLCI2MCIsIiIsIjctMjAgZGF5cyIsIlNLVUM5MTA3MCIsIiIsIiIsImh0dHA6XC9cL2hzdC50cmFkZWRvdWJsZXIuY29tXC9maWxlXC8yODM2NzVcL2xvZ29zXC9OZXdDaGljX2xvZ28uanBnIiwiTmV3Y2hpYyIsIjMuNjkiLCI0YTY0Zjc0ZS00NTlmLTQ3MjAtOTQ2ZC0yN2M1NWRkMzZlMDkiXQ==';

        // when
        $expected_value = [
            'name' => 'Slip Mens Multi Color Block Casual Chemises respirantes à manches longues',
            'slug' => 'slip-mens-multi-color-block-casual-chemises-respirantes-manches-longues-skuc91070',
            'description' => "Spécification :Couleur: Bleu,rouge\nTaille: M,L,XL,2XL,3XL\nMatériel: Polyester\nStyle (occasion): Mode,Décontractée,tous les jours\nModèle: Bloc de couleur\nMarque: Ch\nArmkp\nR\nManche:  Manche longue\nType d'ajustement: En vrac\nStyle: Décontractée\nÉpaisseur: Ordinaire\nLongueur: Ordinaire\nDécorations: Poche, Boutons\nSaison:  Été,Tomber\nType de fermeture: Bouton\nCollier:  Collier de descente\nEmballage inclus:1 * chemise\nNotez s'il vous plaît:1.Veuillez consulter la référence de taille pour trouver la taille correcte.",
            'brand_original' => 'Newchic',
            'merchant_original' => 'Newchic',
            'currency_original' => 'EUR',
            'category_original' => 'men > chemises > long sleeve shirt',
            'color_original' => '',
            'price' => 18.51,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://pdt.tradedoubler.com/click?a(3133632)p(283680)product(4a64f74e-459f-4720-946d-27c55dd36e09)ttid(3)url(https%3A%2F%2Fwww.newchic.com%2Ffr%2Flong-sleeve-shirts-9147%2Fp-1541207.html)',
            'image_url' => 'https://img.banggood.com/images/oaupload/ser1/newchic/images/E7/9C/06e4e45e-05fd-4b8b-9577-4b6127fc48d7.jpg',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => 'manches longues',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => '7-20 days',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Newchic_Femme()
    {
        // given
        $payload = 'WyJNYW50ZWF1IGNvdXJ0IGxcdTAwZTJjaGUgXHUwMGU5dHVkaWFudCBtYXJcdTAwZTllIGJmIHZlbnQgYmFzZWJhbGwgbm9pciIsImh0dHBzOlwvXC9pbWcuYmFuZ2dvb2QuY29tXC9pbWFnZXNcL29hdXBsb2FkXC9zZXIxXC9uZXdjaGljXC9pbWFnZXNcLzNEXC82MFwvNDA2NGY1ZGQtMzJjNi00ODAyLWI4YWMtZTBmNmYzOTRmNDRlLmpwZzo6IiwiVHlwZSBkZSBzdG9jazogRmljaGUgY29tcGxcdTAwZTh0ZU5vbSBkdSB0aXNzdTogUG9seWVzdGVyQ29udGVudSBkZXMgY29tcG9zYW50cyBwcmluY2lwYXV4IGR1IHRpc3N1OiAzMCUgXHUwMGUwIDUwJUluZ3JcdTAwZTlkaWVudHMgcHJpbmNpcGF1eCBkdSB0aXNzdSAyOiBjb3RvblRpc3N1IDIgSW5nclx1MDBlOWRpZW50czogQ290b25UaXNzdSAzIEluZ3JcdTAwZTlkaWVudHM6IENvdG9uSW5nclx1MDBlOWRpZW50cyBsaXF1aWRlczogY290b25Nb3RpZjogY291bGV1ciB1bmllVmVyc2lvbjogZW4gdnJhY0NvbWJpbmFpc29uOiB1bmUgc2V1bGUgcGlcdTAwZThjZVx1MDBjOXBhaXNzZXVyOiBvcmRpbmFpcmVMb25ndWV1ciBkZXMgbWFuY2hlczogbWFuY2hlcyBsb25ndWVzWDogZmVybWV0dXJlIFx1MDBlMCBnbGlzc2lcdTAwZThyZVx1MDBjOWxcdTAwZTltZW50cyBwb3B1bGFpcmVzOiBcdTAwZTlwaXNzdXJlLCBhdXRyZU1cdTAwZTl0aWVyOiBDb2xsYWdlQW5uXHUwMGU5ZSBkZSBjb3RhdGlvbiBcLyBTYWlzb246IEFublx1MDBlOWVMYSBjb3VsZXVyIG5vaXJlVGFpbGxlOiBTLCBNLCBMLCBYTCwgMlhMLCAzWExQb3VyIGwmIzM5O1x1MDBlMmdlOiAxOC0yNCBhbnNUeXBlIGRlIHN0eWxlOiB0cmFqZXQgdGVtcFx1MDBlOXJhbWVudCIsIldvbWVuID4gTUFOVEVBVVggYW5kIFBVTExTID4gVmVzdGVzIGFuZCBHaWxldHM7OyIsIiIsIiIsIiIsIiIsIk5ld2NoaWMiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCJTS1VEMTM5NTUiLCIyODA4NSIsImh0dHBzOlwvXC9wZHQudHJhZGVkb3VibGVyLmNvbVwvY2xpY2s/YSgzMTMzNjMyKXAoMjgzNjgwKXByb2R1Y3QoNWYwMWZmN2QtNDI2Yi00ZjNjLTk0MzktNTFiZmQ3MzYyZThlKXR0aWQoMyl1cmwoaHR0cHMlM0ElMkYlMkZ3d3cubmV3Y2hpYy5jb20lMkZmciUyRmNvYXRzLWFuZC1qYWNrZXRzLTM2NjglMkZwLTE1NDE2NTcuaHRtbCkiLCIxMC43MSIsIkVVUiIsIjE1Nzc5Mjg3NDczMzciLCJFUE9DSCIsIjEyIiwiIiwiNy0yMCBkYXlzIiwiU0tVRDEzOTU1IiwiIiwiIiwiaHR0cDpcL1wvaHN0LnRyYWRlZG91Ymxlci5jb21cL2ZpbGVcLzI4MzY3NVwvbG9nb3NcL05ld0NoaWNfbG9nby5qcGciLCJOZXdjaGljIiwiNC42MiIsIjVmMDFmZjdkLTQyNmItNGYzYy05NDM5LTUxYmZkNzM2MmU4ZSJd';

        // when
        $expected_value = [
            'name' => 'Manteau court lâche étudiant marée bf vent baseball noir',
            'slug' => 'manteau-court-l-che-tudiant-mar-e-bf-vent-baseball-noir-skud13955',
            'description' => "Type de stock: Fiche complète\nNom du tissu: Polyester\nContenu des composants principaux du tissu: 30% à 50%\nIngrédients principaux du tissu 2: coton\nTissu 2 Ingrédients: Coton\nTissu 3 Ingrédients: Coton\nIngrédients liquides: coton\nMotif: couleur unie\nVersion: en vrac\nCombinaison: une seule pièce\nÉpaisseur: ordinaire\nLongueur des manches: manches longues\nX: fermeture à glissière\nÉléments populaires: épissure, autre\nMétier: Collage\nAnnée de cotation / Saison: Année\nLa couleur noire\nTaille: S, M, L, XL, 2XL, 3XL\nPour l'âge: 18-24 ans\nType de style: trajet tempérament",
            'brand_original' => 'Newchic',
            'merchant_original' => 'Newchic',
            'currency_original' => 'EUR',
            'category_original' => 'women > manteaux and pulls > vestes and gilets',
            'color_original' => '',
            'price' => 10.71,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://pdt.tradedoubler.com/click?a(3133632)p(283680)product(5f01ff7d-426b-4f3c-9439-51bfd7362e8e)ttid(3)url(https%3A%2F%2Fwww.newchic.com%2Ffr%2Fcoats-and-jackets-3668%2Fp-1541657.html)',
            'image_url' => 'https://img.banggood.com/images/oaupload/ser1/newchic/images/3D/60/4064f5dd-32c6-4802-b8ac-e0f6f394f44e.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => 'manches longues',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '',
            'livraison' => '7-20 days',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Puma_OldPrice()
    {
        $headers = 'name,productImage,description,categories,(field)Sale Price,(field)custom_label_0,(field)Age Group,(field)custom_label_2,(field)Color,(field)additional_image_link,(field)pattern,(field)item_group_id,(field)gender,(field)custom_label_1,(field)gtin,(field)custom_label_4,fields,weight,size,model,brand,manufacturer,techSpecs,shortDescription,promoText,ean,upc,isbn,mpn,sku,feedId,productUrl,priceValue,priceCurrency,modified,dateFormat,inStock,availability,deliveryTime,sourceProductId,warranty,condition,programLogo,programName,shippingCost,id';

        // given
        $payload = 'WyJQVU1BIFNob3J0IGRlIGZvb3QgcG91ciBIb21tZSwgQmxldVwvQmxhbmMsIFRhaWxsZSA0OC01MCIsImh0dHBzOlwvXC9pbWFnZXMucHVtYS5jb21cL2ltYWdlXC91cGxvYWRcL2ZfYXV0byUyQ3FfYXV0byUyQ2JfcmdiOmZhZmFmYSUyQ3dfMjYwJTJDaF8yNjBcL2dsb2JhbFwvNzAyMDc1XC8wNlwvZm5kXC9FRUFcL2ZtdFwvcG5nXC9TaG9ydC1kZS1mb290OjoiLCJTaG9ydCBkZSBmb290IDogVHUgZmVyYXMgYXZlYyB0b24gXHUwMGU5cXVpcGUgdW5lIGVudHJcdTAwZTllIGVuIHNjXHUwMGU4bmUgZGUgcHJvZmVzc2lvbm5lbCBhdmVjIGNlIHNob3J0IGRlIGZvb3QgbFx1MDBlOWdlciBldCBhdGhsXHUwMGU5dGlxdWUgZGUgUFVNQSBxdWkgdGUgcHJvY3VyZSBzaW11bHRhblx1MDBlOW1lbnQgdW4gc291dGllbiBtYXhpbXVtLiBMZSBtYXRcdTAwZTlyaWF1IFx1MDBlMCBmb25jdGlvbm5hbGl0XHUwMGU5IHN1cFx1MDBlOXJpZXVyZSB0cmFuc3BvcnRlIGxhIHRyYW5zcGlyYXRpb24gdmVycyBsJ2V4dFx1MDBlOXJpZXVyIHBvdXIgdW5lIHNlbnNhdGlvbiBhZ3JcdTAwZTlhYmxlIHBlbmRhbnQgdGVzIGVmZm9ydHMuIEdldCByZWFkeSBmb3IgZHJ5IGF2ZWMgZHJ5Q0VMTC4gVHJhbnNwb3J0IFx1MDBlMCBiYXNlIGJpb2xvZ2lxdWUgZGUgbCdodW1pZGl0XHUwMGU5LiBUYWlsbGUgXHUwMGU5bGFzdGlxdWUgYXZlYyBjb3Jkb24uIFNvdWZmbGV0IGVuIGZpbGV0IDogY29uZm9ydCBzdXBcdTAwZTlyaWV1ci4gU2hvcnQgaW50XHUwMGU5cmlldXIgZW4gY2hhXHUwMGVlbmUgZGUgcG9seWVzdGVyLiAxMDAgJSBwaXF1XHUwMGU5IGRlIHBvbHllc3Rlci4gVmlzaXRleiBub3RyZSBwYWdlIHdlYiBwb3VyIHNhdm9pciBwbHVzIHN1ciBub3RyZSAuUFVNQSBTaG9ydCBkZSBmb290IHBvdXIgSG9tbWUgYmxldSwgdGFpbGxlIDQ4LTUwLiIsIkFwcGFyZWwgJiBBY2Nlc3NvcmllcyA+IENsb3RoaW5nID4gU2hvcnRzOzsiLCIxNC4wMCIsIkxlc3MgdGhhbiBcdTIwYWMyNSIsIm1hbGUiLCJNZW4ncyA+IENsb3RoaW5nID4gU2hvcnRzIiwiV2hpdGVcL05ldyBOYXZ5IiwiaHR0cHM6XC9cL2ltYWdlcy5wdW1hLmNvbVwvaW1hZ2VcL3VwbG9hZFwvZl9hdXRvJTJDcV9hdXRvJTJDYl9yZ2I6ZmFmYWZhJTJDd18yMDAwJTJDaF8yMDAwXC9nbG9iYWxcLzcwMjA3NVwvMDZcL2ZuZFwvRUVBLGh0dHBzOlwvXC9pbWFnZXMucHVtYS5jb21cL2ltYWdlXC91cGxvYWRcL2ZfYXV0byUyQ3FfYXV0byUyQ2JfcmdiOmZhZmFmYSUyQ3dfMjAwMCUyQ2hfMjAwMFwvZ2xvYmFsXC83MDIwNzVcLzA2XC9idlwvZm5kXC9FRUEiLCJcdTAwZTlsYXN0aXF1ZVwvcG9seWVzdGVyIiwiNzAyMDc1IiwiNDgtNTAiLCJCZXR3ZWVuIDIwJSAtIDMwJSIsIjQwNTUyNjE0MjM5NDEiLCIiLCIiLCIiLCJBdWN1biIsIiIsIlBVTUEiLCIiLCIiLCJNZW4ncyA+IENsb3RoaW5nID4gU2hvcnRzLEhvbW1lID4gVlx1MDBlYXRlbWVudHMgPiBTaG9ydHMiLCIiLCIiLCIiLCIiLCI3MDIwNzVfMDZfNDgtNTAiLCIiLCIxMzQ1NSIsImh0dHBzOlwvXC9wZHQudHJhZGVkb3VibGVyLmNvbVwvY2xpY2s/YSgzMTMzNjMyKXAoMTkwMzE4KXByb2R1Y3QoNWJjOGYyY2ItN2U2OC00N2M1LWI0MDItMzhkNzcyNzdkNGViKXR0aWQoMyl1cmwoaHR0cHMlM0ElMkYlMkZldS5wdW1hLmNvbSUyRmZyJTJGZnIlMkZwZCUyRnNob3J0LWRlLWZvb3QlMkY3MDIwNzUuaHRtbCUzRmR3dmFyXzcwMjA3NV9zaXplJTNEMDIxMCUyNmR3dmFyXzcwMjA3NV9jb2xvciUzRDA2KSIsIjIwLjAwIiwiRVVSIiwiMTU3NzU3NjUyMjMxNCIsIkVQT0NIIiwiIiwib3V0IG9mIHN0b2NrIiwiIiwiNzAyMDc1XzA2XzQ4LTUwIiwiIiwibmV3IiwiaHR0cDpcL1wvaHN0LnRyYWRlZG91Ymxlci5jb21cL2ZpbGVcLzE5MDMxOFwvcHVtYV9hXzEwMF8zNS5qcGciLCJQVU1BIiwiYWR1bHQiLCI1YmM4ZjJjYi03ZTY4LTQ3YzUtYjQwMi0zOGQ3NzI3N2Q0ZWIiXQ==';

        // when
        $expected_value = [
            'name' => 'Short de foot, Bleu/Blanc, Taille 48-50',
            'slug' => 'puma-short-de-foot-pour-homme-bleu-blanc-taille-48-50',
            'description' => "Short de foot : Tu feras avec ton équipe une entrée en scène de professionnel avec ce short de foot léger et athlétique de PUMA qui te procure simultanément un soutien maximum. Le matériau à fonctionnalité supérieure transporte la transpiration vers l'extérieur pour une sensation agréable pendant tes efforts. Get ready for dry avec dryCELL. Transport à base biologique de l'humidité. Taille élastique avec cordon. Soufflet en filet : confort supérieur. Short intérieur en chaîne de polyester. 100 % piqué de polyester. Visitez notre page web pour savoir plus sur notre .PUMA Short de foot pour Homme bleu, taille 48-50.",
            'brand_original' => 'PUMA',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'apparel & accessories > clothing > shorts',
            'color_original' => 'white|new navy',
            'price' => 14.0,
            'old_price' => 20.0,
            'reduction' => 30.0,
            'url' => 'https://pdt.tradedoubler.com/click?a(3133632)p(190318)product(5bc8f2cb-7e68-47c5-b402-38d77277d4eb)ttid(3)url(https%3A%2F%2Feu.puma.com%2Ffr%2Ffr%2Fpd%2Fshort-de-foot%2F702075.html%3Fdwvar_702075_size%3D0210%26dwvar_702075_color%3D06)',
            'image_url' => 'https://images.puma.com/image/upload/f_auto%2Cq_auto%2Cb_rgb:fafafa%2Cw_260%2Ch_260/global/702075/06/fnd/EEA/fmt/png/Short-de-foot',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'AUCUN',
            'livraison' => '',
        ];

        $this->markTestIncomplete('need new payload');

        // then
        $this->assertEquals(
      $this->parse_payload($payload, $headers),
      $expected_value
    );
    }

    public function test__parse_row__from_Intimissimi_Femme()
    {
        $headers = 'name,productImage,productUrl,imageUrl,height,width,categories,MerchantCategoryName,TDCategoryName,TDCategoryId,TDProductId,description,feedId,groupingId,id,language,modified,price,currency,programName,availability,brand,condition,deliveryTime,ean,upc,isbn,mpn,sku,identifiers,inStock,manufacturer,model,programLogo,promoText,shippingCost,shortDescription,size,fields,warranty,weight,techSpecs,dateformat';

        // given
        $payload = 'WyJTbGlwIFNlbWktSGF1dCBlbiBEZW50ZWxsZSBldCBDb3RvbiBOYXR1cmVsIiwiaHR0cHM6XC9cL2ltYWdlcy5jYWx6ZWRvbmlhLmNvbVwvZ2V0XC9TSUQ5MUFfd2Vhcl8wMDFfRDEuanBnOjoiLCJodHRwczpcL1wvcGR0LnRyYWRlZG91Ymxlci5jb21cL2NsaWNrP2EoMzEzMzYzMilwKDI5MzI1MSlwcm9kdWN0KGJhYjM3ODI3LWJlMzUtNGUyOC1hODc1LTIwMjU4MmY4MWZiNCl0dGlkKDMpdXJsKGh0dHBzJTNBJTJGJTJGdHJhY2suYWRmb3JtLm5ldCUyRkMlMkYlM0ZibiUzRDI4OTM2NzA1JTNCY3BkaXIlM0RodHRwcyUzQSUyRiUyRnd3dy5pbnRpbWlzc2ltaS5jb20lMkZmciUyRnByb2R1Y3QlMkZzbGlwX3NlbWktaGF1dF9lbl9kZW50ZWxsZV9ldF9jb3Rvbl9uYXR1cmVsLVNJRDkxQS5odG1sJTNGZHd2YXJfU0lEOTFBX1pfQ09MX0lOVEQlM0QwMDElMjZ1dG1fc291cmNlJTNEdHJhZGVkb3VibGVyJTI2dXRtX21lZGl1bSUzRGFmZmlsaWF0ZSUyNnV0bV9jYW1wYWlnbiUzREFmZl9pbnRpbWlzc2ltaV9mciUyNnV0bV9jb250ZW50JTNEJTVCdGRfc2l0ZV9uYW1lJTVEKSIsImh0dHBzOlwvXC9pbWFnZXMuY2FsemVkb25pYS5jb21cL2dldFwvU0lEOTFBX3dlYXJfMDAxX0QxLmpwZyIsIiIsIiIsIkZlbW1lID4gQ3Vsb3R0ZXMgZXQgYmFzID4gQ3Vsb3R0ZXM7OyIsIkZlbW1lID4gQ3Vsb3R0ZXMgZXQgYmFzID4gQ3Vsb3R0ZXMiLCIiLCIiLCJTSUQ5MUEgICAwMDEgNSIsIlNsaXAgc2VtaS1oYXV0IGVuIGNvdG9uIGV0IGRlbnRlbGxlIEx5Y3JhXHUwMGFlIExhY2UgYXZlYyBwZXRpdCBuXHUwMTUzdWQgYXUgY2VudHJlLiBMJ291cmxldCBlc3QgcmVoYXVzc1x1MDBlOSBkJ3VuIHZvbGFudCBlbiBkZW50ZWxsZS4gSWRcdTAwZTlhbCBwb3VyIGNlbGxlcyBxdWkgY2hlcmNoZW50IHVuZSBwaVx1MDBlOGNlIGNvbmZvcnRhYmxlIGV0IHJvbWFudGlxdWUuIiwiMzExMDUiLCIiLCJiYWIzNzgyNy1iZTM1LTRlMjgtYTg3NS0yMDI1ODJmODFmYjQiLCJmciIsIjE1Nzk1NzEwOTMxOTgiLCIxMC4wMCIsIkVVUiIsIkludGltaXNzaW1pIiwiIiwiSW50aW1pc3NpbWkiLCJuZXciLCI0IiwiIiwiIiwiIiwiIiwiU0lEOTFBICAgMDAxIDUiLCI6OjpTSUQ5MUEgICAwMDEgNToiLCIxMyIsIiIsIiIsImh0dHA6XC9cL2hzdC50cmFkZWRvdWJsZXIuY29tXC9maWxlXC8yOTMyNTFcL2xvZ29zXC9JbnRpbWlzc2ltaU9UVkVULnBuZyIsIiIsIjAiLCIiLCI1IiwiIiwiIiwiIiwiIiwiRVBPQ0giXQ==';

        // when
        $expected_value = [
            'name' => 'Slip Semi-Haut en Dentelle et Coton Naturel',
            'slug' => 'slip-semi-haut-en-dentelle-et-coton-naturel-sid91a-001-5',
            'description' => 'Slip semi-haut en coton et dentelle Lycra® Lace avec petit nœud au centre. L\'ourlet est rehaussé d\'un volant en dentelle. Idéal pour celles qui cherchent une pièce confortable et romantique.',
            'brand_original' => 'Intimissimi',
            'merchant_original' => 'Intimissimi',
            'currency_original' => 'EUR',
            'category_original' => 'femme > culottes et bas > culottes',
            'color_original' => '',
            'price' => 10,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://pdt.tradedoubler.com/click?a(3133632)p(293251)product(bab37827-be35-4e28-a875-202582f81fb4)ttid(3)url(https%3A%2F%2Ftrack.adform.net%2FC%2F%3Fbn%3D28936705%3Bcpdir%3Dhttps%3A%2F%2Fwww.intimissimi.com%2Ffr%2Fproduct%2Fslip_semi-haut_en_dentelle_et_coton_naturel-SID91A.html%3Fdwvar_SID91A_Z_COL_INTD%3D001%26utm_source%3Dtradedoubler%26utm_medium%3Daffiliate%26utm_campaign%3DAff_intimissimi_fr%26utm_content%3D%5Btd_site_name%5D)',
            'image_url' => 'https://images.calzedonia.com/get/SID91A_wear_001_D1.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '5',
            'livraison' => '4',
        ];

        // then
        $this->assertEquals(
      $this->parse_payload($payload, $headers),
      $expected_value
    );
    }
}
