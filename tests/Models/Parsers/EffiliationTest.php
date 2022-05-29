<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Effiliation;

class EffiliationTest extends \Tests\Models\SourceTest
{
    public static $klass = Effiliation::class;

    public static $headers = 'additional_image_link,additional_image_link2,additional_image_link3,additional_image_link4,age_group,availability,availability_date,brand,category,category_level2,category_level3,category_level4,color,condition,currency,custom_label_0,custom_label_1,custom_label_2,custom_label_3,custom_label_4,description,ecotax,energy_efficiency_class,expiration_date,gender,google_product_category,gtin,id,image_link,is_bundle,item_group_id,link,material,mobile_link,mpn,multipack,pattern,pneu_charge,pneu_diametre,pneu_fueleconomy,pneu_hauteur,pneu_largeur,pneu_modele,pneu_noisedb,pneu_noiselevel,pneu_rechape,pneu_renforce,pneu_runflat,pneu_saison,pneu_vitesse,pneu_wetadhesion,price,price_norebate,rebate_end_date,rebate_start_date,sale_price_effective_date,shipping,shipping_cost,shipping_height,shipping_length,shipping_time,shipping_weight,shipping_width,size,size_system,size_type,stock,style,title,warranty';

    public function test__parse_row__from_Eden_Park_Homme()
    {
        // given
        $payload = 'WyIiLCIiLCIiLCIiLCIiLCIwMDEiLCIiLCJFZGVuIFBhcmsiLCJIT01NRSIsIkNBUkRJR0FOIiwiUHJvZHVpdHMgUGVybWFuZW50cyIsIiIsIk1BUklORSBFUCIsIjEiLCJFVVIiLCIiLCIiLCIiLCIiLCIiLCJTaSBjZSBjaGljIGNhcmRpZ2FuIGVuIDEwMCUgY290b24gZGUgcXVhbGl0XHUwMGU5IHNvcnQgZGUgbCdvcmRpbmFpcmUsIGMnZXN0IHF1J2lsIGFmZmljaGUgdW4gY29sIGNvbnRyYXN0XHUwMGU5IGV0IHVuZSBkZW1pLWx1bmUgcmF5XHUwMGU5ZS4gRGVzIGRcdTAwZTl0YWlscyBkaXNjcmV0cyBxdWkgbGUgZm9udCByZW50cmVyIGRhbnMgbGEgY291ciBkZXMgbW9kXHUwMGU4bGVzIGVzc2VudGllbHMgZG9udCBvbiBuZSBwZXV0IHBsdXMgc2UgcGFzc2VyLiBSZWd1bGFyIGZpdCAxMDAgJSBjb3RvbiBDb2wgbW9udGFudCBjb250cmFzdFx1MDBlOSBGZXJtZXR1cmUgemlwcFx1MDBlOWUgXHUwMGUwIGRvdWJsZSBjdXJzZXVyIEZpbml0aW9ucyBib3JkLWNcdTAwZjR0ZSBEZW1pLWx1bmUgY29udHJhc3RcdTAwZTllIHJheVx1MDBlOWUgYmljb2xvcmUgTG9nbyBudWQgcGFwaWxsb24gcm9zZSBicm9kXHUwMGU5IHBvaXRyaW5lIiwiMCIsIiIsIiIsIkhvbW1lIiwiIiwiMzYwNjM3NzA5MjcyMiIsIlBQS05JQ0FFMDAwMVwvQkxGXC8yWEwiLCJodHRwczpcL1wvd3d3LmVkZW4tcGFyay5mclwvbWVkaWFcL2NhY2hlXC9jYXRhbG9nXC9wcm9kdWN0XC9wXC9wXC83MDB4NzAwXC9wcGtuaWNhZTAwMDFfYmxmXzJ4bC1wcGtuaWNhZTAwMDFfYmxmX2hkLWZhY2UuanBnIiwiIiwiOTg2NTYiLCJodHRwczpcL1wvdHJhY2suZWZmaWxpYXRpb24uY29tXC9zZXJ2bGV0XC9lZmZpLnJlZGlyP2lkX2NvbXB0ZXVyPTIyNDY3MTM0JnVybD1odHRwcyUzQSUyRiUyRnd3dy5lZGVuLXBhcmsuZnIlMkZmcl9mciUyRmNhcmRpZ2FuLWJsZXUtbWFyaW5lLXJlZ3VsYXItZml0LWVuLWNvdG9uLWEtY29sLW1vbnRhbnQtY29udHJhc3RlLW1hcmluZS05ODY1Ni5odG1sJTNGTEdXQ09ERSUzRFBQS05JQ0FFMDAwMUJMRjJYTCUzQjE0NzAwMyUzQjg5MDkiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIxMTUuMDAiLCIxMTUuMDAiLCIiLCIiLCIiLCJGbGF0cmF0ZSIsIjAiLCIiLCIiLCIzIiwiMC4wMDAwIiwiIiwiMlhMIiwiIiwiIiwiNzUiLCIxMDAlIGNvdG9uIiwiQ2FyZGlnYW4gYmxldSBtYXJpbmUgcmVndWxhciBmaXQgZW4gY290b24gXHUwMGUwIGNvbCBtb250YW50IGNvbnRyYXN0XHUwMGU5IG1hcmluZSIsIiJd';

        // when
        $expected_value = [
            'name' => 'Cardigan bleu marine regular fit en coton à col montant contrasté marine',
            'slug' => 'cardigan-bleu-marine-regular-fit-en-coton-col-montant-contrast-marine-ppknicae0001-blf-2xl',
            'description' => 'Si ce chic cardigan en 100% coton de qualité sort de l\'ordinaire, c\'est qu\'il affiche un col contrasté et une demi-lune rayée. Des détails discrets qui le font rentrer dans la cour des modèles essentiels dont on ne peut plus se passer. Regular fit 100 % coton Col montant contrasté Fermeture zippée à double curseur Finitions bord-côte Demi-lune contrastée rayée bicolore Logo nud papillon rose brodé poitrine',
            'brand_original' => 'Eden Park',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'homme|cardigan|produits permanents',
            'color_original' => 'marine ep',
            'price' => 115,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22467134&url=https%3A%2F%2Fwww.eden-park.fr%2Ffr_fr%2Fcardigan-bleu-marine-regular-fit-en-coton-a-col-montant-contraste-marine-98656.html%3FLGWCODE%3DPPKNICAE0001BLF2XL%3B147003%3B8909',
            'image_url' => 'https://www.eden-park.fr/media/cache/catalog/product/p/p/700x700/ppknicae0001_blf_2xl-ppknicae0001_blf_hd-face.jpg',
            'gender' => 'homme',
            'col' => 'col montant',
            'coupe' => '',
            'manches' => '',
            'material' => 'coton',
            'model' => 'PPKNICAE0001/BLF/2XL',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '2XL',
            'livraison' => '3 days',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Maison_123_Femme()
    {
        // given
        $payload = 'WyJodHRwczpcL1wvd3d3Lm1haXNvbjEyMy5jb21cL2R3XC9pbWFnZVwvdjJcL0FBV1dfUFJEXC9vblwvZGVtYW5kd2FyZS5zdGF0aWNcLy1cL1NpdGVzLVVQQVAtbWFzdGVyXC9kZWZhdWx0XC9kdzJiMzY4OTJjXC82NTExMjUyNzVfNi5qcGc/c3c9NjAwJnNoPTcxMCIsImh0dHBzOlwvXC93d3cubWFpc29uMTIzLmNvbVwvZHdcL2ltYWdlXC92MlwvQUFXV19QUkRcL29uXC9kZW1hbmR3YXJlLnN0YXRpY1wvLVwvU2l0ZXMtVVBBUC1tYXN0ZXJcL2RlZmF1bHRcL2R3MmFjMDM0ZTJcLzY1MTEyNTI3NV9hLmpwZz9zdz02MDAmc2g9NzEwIiwiaHR0cHM6XC9cL3d3dy5tYWlzb24xMjMuY29tXC9kd1wvaW1hZ2VcL3YyXC9BQVdXX1BSRFwvb25cL2RlbWFuZHdhcmUuc3RhdGljXC8tXC9TaXRlcy1VUEFQLW1hc3RlclwvZGVmYXVsdFwvZHdiZWRlMjYwOVwvNjUxMTI1Mjc1X2IuanBnP3N3PTYwMCZzaD03MTAiLCIiLCJhZHVsdCIsIkRpc3BvbmlibGUgaW1tXHUwMGU5ZGlhdGVtZW50IiwiIiwiMTIzIiwiVG9wcyIsIiIsIiIsIiIsIkZMQU1NRSIsIm5ldyIsIkVVUiIsIiIsIiIsIiIsIiIsIiIsIkNvdXAgZGUgY29ldXIgcG91ciBjZXR0ZSBjaGVtaXNlIGVuIHNvaWUuIERcdTAwZTlsaWNhdGUgZXQgcmFmZmluXHUwMGU5ZSwgY2UgbW9kXHUwMGU4bGUgaW50ZW1wb3JlbCB2b3VzIGRvbm5lcmEgdW4gbG9vayBcdTAwZTlsXHUwMGU5Z2FudCBldCBzb3BoaXN0aXF1XHUwMGU5LiBPbiBhaW1lIHNhIG1hdGlcdTAwZThyZSBmbHVpZGUgZXQgc295ZXVzZSBldCBzb24gcG9ydFx1MDBlOSB1bHRyYSBhZ3JcdTAwZTlhYmxlLiAtIDEwMCUgc29pZSAtIGNvbCBjaGVtaXNpZXIgYXZlYyBib3V0b25zIC0gY291bGV1ciBmbGFtYm95YW50ZSBFbGlzZSBtZXN1cmUgMW03NSBldCBwb3J0ZSB1bmUgVC4zNiIsIiIsIiIsIiIsIkZlbW1lIiwiIiwiIiwiNjUxMTI1Mjc1IiwiaHR0cHM6XC9cL3d3dy5tYWlzb24xMjMuY29tXC9kd1wvaW1hZ2VcL3YyXC9BQVdXX1BSRFwvb25cL2RlbWFuZHdhcmUuc3RhdGljXC8tXC9TaXRlcy1VUEFQLW1hc3RlclwvZGVmYXVsdFwvZHdkMTEyZGQzYVwvNjUxMTI1Mjc1X3guanBnP3N3PTYwMCZzaD03MTAiLCIiLCIiLCJodHRwczpcL1wvdHJhY2suZWZmaWxpYXRpb24uY29tXC9zZXJ2bGV0XC9lZmZpLnJlZGlyP2lkX2NvbXB0ZXVyPTIyNDYzNjM3JnVybD1odHRwcyUzQSUyRiUyRnd3dy5tYWlzb24xMjMuY29tJTJGZnIlMkZ0b3BzJTJGY2hlbWlzZS1lbi1zb2llLXJvdWdlLW1hZWxsZS02NTExMjUyNzUuaHRtbCIsIk1BVElFUkUgUFJJTkNJUEFMRSA6IDEwMC4wMCAlIFNvaWUgQk9VVE9OIDogMTAwLjAwICUgTmFjcmUiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCI1NC41MCIsIjEwOS4wMCIsIiIsIiIsIiIsIkZyYWlzIGRlIHBvcnQgb2ZmZXJ0cyBkZXMgMTIwRVVSIiwiRlI6OkxpdnJhaXNvbiBlbiBtYWdhc2luOjAuMDAgRVVSLEZSOjpDb2xpc3NpbW8gc3Vpdmk6Ny4wMCBFVVIsRlI6OlBvaW50IHJlbGFpcyBLaWFsYTo0LjUwIEVVUiIsIiIsIiIsIkxpdnJhaXNvbiBzb3VzIDIgXHUwMGUwIDUgam91cnMiLCIiLCIiLCIzNiwzOCw0MCw0Miw0NCw0NiIsIiIsIiIsIjMyIiwiIiwiQ2hlbWlzZSBlbiBzb2llIHJvdWdlIG1hZWxsZSIsIiJd';

        // when
        $expected_value = [
            'name' => 'Chemise en soie rouge maelle',
            'slug' => 'chemise-en-soie-rouge-maelle-651125275',
            'description' => 'Coup de coeur pour cette chemise en soie. Délicate et raffinée, ce modèle intemporel vous donnera un look élégant et sophistiqué. On aime sa matière fluide et soyeuse et son porté ultra agréable. - 100% soie - col chemisier avec boutons - couleur flamboyante Elise mesure 1m75 et porte une T.36',
            'brand_original' => '123',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'tops',
            'color_original' => 'flamme',
            'price' => 54.5,
            'old_price' => 109,
            'reduction' => 50,
            'url' => 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22463637&url=https%3A%2F%2Fwww.maison123.com%2Ffr%2Ftops%2Fchemise-en-soie-rouge-maelle-651125275.html',
            'image_url' => 'https://www.maison123.com/dw/image/v2/AAWW_PRD/on/demandware.static/-/Sites-UPAP-master/default/dwd112dd3a/651125275_x.jpg?sw=600&sh=710',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'soie bouton|nacre',
            'model' => '651125275',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '36|38|40|42|44|46',
            'livraison' => 'Livraison sous 2 à 5 jours',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Eden_Park_Unisex()
    {
        // given
        $payload = 'WyIiLCIiLCIiLCIiLCIiLCIwMDEiLCIiLCJFZGVuIFBhcmsiLCIiLCIiLCIiLCIiLCIiLCIxIiwiRVVSIiwiIiwiIiwiIiwiIiwiIiwiQWN0dWFsaXNleiB2b3RyZSBjb2xsZWN0aW9uIGRlIHQtc2hpcnRzIGF2ZWMgY2Ugbm91dmVhdSBtb2RcdTAwZThsZSBFZGVuIFBhcmsgc2lnbmF0dXJlLiBEXHUwMGU5Y29yXHUwMGU5IHBhciB1biB2aXN1ZWwgZ3JhcGhpcXVlIGltcHJpbVx1MDBlOSBzdXIgbGEgcG9pdHJpbmUsIGlsIHByXHUwMGU5c2VudGUgdW4gY29sIHJvbmQgZW4gYm9yZC1jXHUwMGY0dGUgZXQgZGVzIGZpbml0aW9ucyBzb2lnblx1MDBlOWVzLiBQb3VyIHRyYXZlcnNlciBsJ1x1MDBlOXRcdTAwZTksIGFkb3B0ZXogc2FucyBoXHUwMGU5c2l0ZXIgc2EgY291cGUgY2xhc3NpcXVlIGV0IHNvbiBqZXJzZXkgZGUgY290b24gcGFydGljdWxpXHUwMGU4cmVtZW50IGRvdXggZXQgY29uZm9ydGFibGUuIFJlZ3VsYXIgZml0IDEwMCAlIGNvdG9uIENvbCByb25kIGJvcmQtY1x1MDBmNHRlIERlbWktbHVuZSBjb250cmFzdFx1MDBlOWUgU2lnbmF0dXJlIEVkZW4gUGFyayBzXHUwMGU5cmlncmFwaGlcdTAwZTllIGRldmFudCBMb2dvIG51ZCBwYXBpbGxvbiB0cmljb2xvcmUgYmxldSBibGFuYyByb3VnZSBicm9kXHUwMGU5IFx1MDBlOXBhdWxlIGdhdWNoZS4iLCIwIiwiIiwiIiwiVW5pc2V4ZSIsIiIsIjM2MDYzNzgyMzg5ODMiLCJFMjBNQUlUQzAwMTNcL0dSTVwvWEwiLCJodHRwczpcL1wvd3d3LmVkZW4tcGFyay5mclwvbWVkaWFcL2NhY2hlXC9jYXRhbG9nXC9wcm9kdWN0XC9lXC8yXC83MDB4NzAwXC9lMjBtYWl0YzAwMTNfZ3JtX3hsLWUyMG1haXRjMDAxM19ncm1faGQtbWZhY2UuanBnIiwiIiwiMTE5Mjk0IiwiaHR0cHM6XC9cL3RyYWNrLmVmZmlsaWF0aW9uLmNvbVwvc2VydmxldFwvZWZmaS5yZWRpcj9pZF9jb21wdGV1cj0yMjQ2NzEzNCZ1cmw9aHR0cHMlM0ElMkYlMkZ3d3cuZWRlbi1wYXJrLmZyJTJGZnJfZnIlMkZ0LXNoaXJ0LWdyaXMtZW4tamVyc2V5LWRlLWNvdG9uLWltcHJpbWUtMTE3ODM1Lmh0bWwlM0ZMR1dDT0RFJTNERTIwTUFJVEMwMDEzR1JNWEwlM0IxNDcwMDMlM0I4OTA5IiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiNTUuMDAiLCI1NS4wMCIsIiIsIiIsIiIsIkZsYXRyYXRlIiwiNS45MCIsIiIsIiIsIjMiLCIiLCIiLCJYTCIsIiIsIiIsIjEyIiwiIiwiVC1zaGlydCBncmlzIGVuIGplcnNleSBkZSBjb3RvbiBpbXByaW1cdTAwZTkiLCIiXQ==';

        // when
        $expected_value = [
            'name' => 'T-shirt gris en jersey de coton imprimé',
            'slug' => 't-shirt-gris-en-jersey-de-coton-imprim-e20maitc0013-grm-xl',
            'description' => 'Actualisez votre collection de t-shirts avec ce nouveau modèle Eden Park signature. Décoré par un visuel graphique imprimé sur la poitrine, il présente un col rond en bord-côte et des finitions soignées. Pour traverser l\'été, adoptez sans hésiter sa coupe classique et son jersey de coton particulièrement doux et confortable. Regular fit 100 % coton Col rond bord-côte Demi-lune contrastée Signature Eden Park sérigraphiée devant Logo nud papillon tricolore bleu blanc rouge brodé épaule gauche.',
            'brand_original' => 'Eden Park',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => '',
            'color_original' => '',
            'price' => 55,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22467134&url=https%3A%2F%2Fwww.eden-park.fr%2Ffr_fr%2Ft-shirt-gris-en-jersey-de-coton-imprime-117835.html%3FLGWCODE%3DE20MAITC0013GRMXL%3B147003%3B8909',
            'image_url' => 'https://www.eden-park.fr/media/cache/catalog/product/e/2/700x700/e20maitc0013_grm_xl-e20maitc0013_grm_hd-mface.jpg',
            'gender' => 'mixte',
            'col' => 'col rond',
            'coupe' => 'coupe classique/droite',
            'manches' => '',
            'material' => '',
            'model' => 'E20MAITC0013/GRM/XL',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'XL',
            'livraison' => '3 days',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_San_Marina_Unisex()
    {
        // given
        $payload = 'WyIiLCIiLCIiLCIiLCIiLCIwMDYiLCIiLCJTYW4gTWFyaW5hIiwiIiwiIiwiQXVjdW5lIiwiIiwiTEVTIEJFSUdFUyIsIjEiLCJldXJvcyIsIiIsIiIsIiIsIiIsIiIsIkN1aXNzYXJkZXMgQUxFQU5BIEluc3Bpclx1MDBlOWVzIGRlcyBhbm5cdTAwZTllcyA2MCwgbGVzIGN1aXNzYXJkZXMgZG9ubmVudCB1biBjYXJhY3RcdTAwZThyZSB1bmlxdWUgXHUwMGUwIHZvdHJlIGxvb2sgISBFbiBjcm9cdTAwZmJ0ZSB2ZWxvdXJzLCBlbGxlcyBoYWJpbGxlbnQgdm9zIGphbWJlcyBkZSBkb3VjZXVyIGV0IGRlIGZcdTAwZTltaW5pdFx1MDBlOSBwb3VyIGFsbG9uZ2VyIHZvdHJlIHNpbGhvdWV0dGUgYXUgbWF4aW11bS4gTXVuaWVzIGQndW5lIHNhbmdsZSBcdTAwZTAgbCdhcnJpXHUwMGU4cmUsIGVsbGVzIHJlc3RlbnQgZW4gYm9ubmUgcGxhY2UgdG91dCBhdSBsb25nIGRlIGxhIGpvdXJuXHUwMGU5ZS4uIFBhc3NleiBlbiBtb2RlIHByZXBweSBlbiBhc3NvY2lhbnQgY2V0dGUgY3Vpc3NhcmRlIFx1MDBlMCB1bmUganVwZSB0cmFwXHUwMGU4emUgZXQgXHUwMGUwIHVuIGNoZW1pc2llciBcdTAwZTAgcG9pcy4gR3JcdTAwZTJjZSBcdTAwZTAgc29uIHBldGl0IHRhbG9uLCBlbGxlIGRldmllbnQgbGEgcGlcdTAwZThjZSBtYVx1MDBlZXRyZXNzZSBkZSB2b3MgdGVudWVzIHF1b3RpZGllbm5lcyAhIiwiIiwiIiwiIiwiIiwiIiwiIiwiQTM2MTAyNzM2MjI4NyIsImh0dHBzOlwvXC93d3cuc2FubWFyaW5hLmZyXC9kd1wvaW1hZ2VcL3YyXC9CQ0xCX1BSRFwvb25cL2RlbWFuZHdhcmUuc3RhdGljXC8tXC9TaXRlcy1TQU0tbWFzdGVyLWNhdGFsb2dcL2RlZmF1bHRcL1wvaW1hZ2VzXC9BTEVBTkFfQ0FNRUxfQS5qcGciLCIiLCIiLCJodHRwczpcL1wvdHJhY2suZWZmaWxpYXRpb24uY29tXC9zZXJ2bGV0XC9lZmZpLnJlZGlyP2lkX2NvbXB0ZXVyPTIyNDYzNjM4JnVybD1odHRwcyUzQSUyRiUyRnd3dy5zYW5tYXJpbmEuZnIlMkZjdWlzc2FyZGUtYWxlYW5hLTE4MzI1NTE2Lmh0bWwiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIxNjkuMDAiLCIxNjkuMDAiLCIiLCIiLCIiLCIiLCI2IiwiIiwiIiwic291cyA1IFx1MDBlMCA2IGpvdXJzIiwiIiwiIiwiNDEiLCIiLCIiLCIiLCIiLCJDVUlTU0FSREUgQUxFQU5BIiwiIl0=';

        // when
        $expected_value = [
            'name' => 'CUISSARDE ALEANA',
            'slug' => 'cuissarde-aleana-a361027362287',
            'description' => 'Cuissardes ALEANA Inspirées des années 60, les cuissardes donnent un caractère unique à votre look ! En croûte velours, elles habillent vos jambes de douceur et de féminité pour allonger votre silhouette au maximum. Munies d\'une sangle à l\'arrière, elles restent en bonne place tout au long de la journée.. Passez en mode preppy en associant cette cuissarde à une jupe trapèze et à un chemisier à pois. Grâce à son petit talon, elle devient la pièce maîtresse de vos tenues quotidiennes !',
            'brand_original' => 'San Marina',
            'merchant_original' => 'Source Title',
            'currency_original' => 'EUR',
            'category_original' => 'aucune',
            'color_original' => 'les beiges',
            'price' => 169,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://track.effiliation.com/servlet/effi.redir?id_compteur=22463638&url=https%3A%2F%2Fwww.sanmarina.fr%2Fcuissarde-aleana-18325516.html',
            'image_url' => 'https://www.sanmarina.fr/dw/image/v2/BCLB_PRD/on/demandware.static/-/Sites-SAM-master-catalog/default//images/ALEANA_CAMEL_A.jpg',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => 'A361027362287',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '41',
            'livraison' => 'sous 5 à 6 jours',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
