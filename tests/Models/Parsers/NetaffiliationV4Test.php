<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\NetaffiliationV4;

class NetaffiliationV4Test extends \Tests\Models\SourceTest
{
    public static $klass = NetaffiliationV4::class;

    public function test__parse_row__from_3Suisses()
    {
        $headers = 'categorie,identifiant_unique,titre,description,prix,URL_produit,URL_image,frais_de_port,disponibilite,delai_de_livraison,garantie,reference_modele,D3E,marque,ean,prix_barre,devise,occasion,type_promotion,couleur,matiere,taille,type,mobile_url,categorie_id,id_parent,identifiant complet';

        // given
        $payload = 'WyJWXHUwMGVhdGVtZW50cyBldCBhY2Nlc3NvaXJlcyA+IFZcdTAwZWF0ZW1lbnRzID4gU291cy12XHUwMGVhdGVtZW50cyBldCBjaGF1c3NldHRlcyA+IFNvdXRpZW5zLWdvcmdlcyIsIjIxMzQyOE1DMjAwODU4IiwiUHJvbW8gOiBTb3V0aWVuLUdvcmdlIEJhbGNvbm5ldCBDaGFpciIsIjNTdWlzc2VzIDogIDc3JSBQb2x5YW1pZGUsIDE1JSBQb2x5ZXN0ZXIsIDglIEVsYXN0YW5lIFBSXHUwMGM5U0VOVEFUSU9OIExhIGxlbW9uIHRlYW0gYSBzXHUwMGU5bGVjdGlvbm5cdTAwZTkgcG91ciB2b3VzIHVuIGluY29udG91cm5hYmxlIFx1MDBlMFx1MDBhMCBhdm9pciBkYW5zIHZvdHJlIGNvbGxlY3Rpb24uQ2Ugc291dGllbi1nb3JnZSBwZWF1IGRlIGxhIGxpZ25lIE1hcmNpZSBlc3QgcGFyZmFpdCBwb3VyIGxlcyBwb2l0cmluZXMgZ1x1MDBlOW5cdTAwZTlyZXVzZXMuIElsIHMnYWRhcHRlIFx1MDBlMFx1MDBhMCB2b3MgZm9ybWVzIHBvdXIgdW4gcmVuZHUgaW5jb21wYXJhYmxlLiBQcm9mb25kIGRlIGJvbm5ldCwgaWwgcGVybWV0IGRlIHZvdXMgc2VudGlyIFx1MDBlMFx1MDBhMCBsJ2Fpc2UgdG91dCBlbiBheWFudCB1biByZW5kdSBzZW5zdWVsLiBWb3VzIGFwcHJcdTAwZTljaWVyZXogZCdcdTAwZWF0cmUgYmllbiBkYW5zIHZvdHJlIGxpbmdlcmllLCB0b3V0IGVuIHJlc3RhbnQgaXJyXHUwMGU5c2lzdGlibGVtZW50IHNleHkuIFNlcyBhcm1hdHVyZXMgZW5nbG9iZW50IHZvdHJlIHBvaXRyaW5lIGV0IGwnZW50cmUtc2VpbnMgZXN0IGFzc2V6IGdyYW5kIHBvdXIgcXVlIHZvdHJlIHBvaXRyaW5lIHNlIHBsYWNlIHBhcmZhaXRlbWVudCBiaWVuIGRhbnMgdm90cmUgc291dGllbi1nb3JnZS4gVm91cyBhdXJleiB1bmUgcG9pdHJpbmUgZGUgclx1MDBlYXZlIGRhbnMgdW4gc291dGllbi1nb3JnZSBqZXVuZSwgdHJlbmR5IGV0IHRvdXQgZW4gZmluZXNzZS5EZSBwbHVzLCB1biB0clx1MDBlOHMgam9saSB0dWxsZSBcdTAwZTBcdTAwYTAgcG9pcyBicm9kXHUwMGU5cyBkb25uZSB1biBhc3BlY3QgZHluYW1pcXVlIGV0IGpvbGltZW50IHJhZmZpblx1MDBlOS4gVm90cmUgc2lsaG91ZXR0ZSBlc3QgbWlzZSBlbiB2YWxldXIgcGFyIGxlIGhhdXQtYm9ubmV0IGJyb2RcdTAwZTkgZmFcdTAwZTdvbiBkZW50ZWxsZSBldCB1biBwZXRpdCBuP3VkIFx1MDBlMFx1MDBhMCBwb2lzIHNhdGluXHUwMGU5IGNvdXN1IFx1MDBlMFx1MDBhMCBsJ2VudHJlLXNlaW5zIGFwcG9ydGVyYSB1bmUgdG91Y2hlIGdpcmx5IFx1MDBlMFx1MDBhMCBsYSBwaVx1MDBlOGNlLiBDb3VsZXVyIGNoYWlyLCBpbCBzZXJhIHBhcmZhaXQgc291cyB1biB0LXNoaXJ0IGJsYW5jLiBPbiBuZSBzJ2VuIGxhc3NlIHBhcyAhIFx1MDBhMCBWZW5leiB2aXRlIGRcdTAwZTljb3V2cmlyIGwnaGlzdG9pcmUgZHUgc291dGllbi1nb3JnZSAhIFx1MDBhMCBBdHRlbnRpb246IFN1ciBsZXMgc291dGllbi1nb3JnZXMgZGUgbGEgbWFycXVlIFBhbmFjaGUsIGwnXHUwMGU5dGlxdWV0dGUgdGV4dGlsZSBpbmRpcXVlIGxhIHRhaWxsZSBVSy4gREQ9RTsgRT1GOyBGPUc7IEZGPUg7IEc9SSBcdTAwYTAgRU5UUkVUSUVOIExhdmFnZSBtYWluIFx1MDBlMFx1MDBhMCBsJ2VhdSB0aVx1MDBlOGRlIHJlY29tbWFuZFx1MDBlOSBvdSBwcm9ncmFtbWUgZFx1MDBlOWxpY2F0IGVuIG1hY2hpbmUgKDMwXHUwMGIwIG1heCksIGRhbnMgdW4gZmlsZXQgZGUgcHJvdGVjdGlvbi4gXHUwMGEwIENPTlNFSUwgU1RZTEUgQ3JhcXVleiBwb3VyIGxlIHBsdW1ldGlzIGV0IGxhbmV6IHZvdXMgZGFucyBsZSBuYWlsIGFydC4gQ09OU0VJTCBUQUlMTEUgVG91ciBkZSBkb3MgdG9uaXF1ZSwgbFx1MDBlOWdcdTAwZThyZW1lbnQgc2Vyclx1MDBlOS4gIE1hcnF1ZTogQ2xlbyBieSBQYW5hY2hlIiwiMzAuMSIsImh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA1MTBBQjc1NjgyMzMxOVMxVUQ0MTMwMGIwMjUwNDE0VjQiLCJodHRwczpcL1wvd3d3LjNzdWlzc2VzLmZyXC9tZWRpYVwvcHJvZHVpdHNcL2NsZW8tYnktcGFuYWNoZVwvaW1nXC9iYWxjb25ldHRlLWJyYS1jbGVvLWJ5LXBhbmFjaGUtbWFyY2llLW51ZGUtNDc4ODdfMTIwMHgxMjAwLmpwZyIsIiIsIjEiLCIyLTQiLCIiLCJMRU1DNjgzMU5VREUxMDBEIiwiIiwiQ2xlbyBieSBQYW5hY2hlIiwiNTA1MTkyODczNTc1MyIsIjQzIiwiRVVSIiwiMCIsIjEiLCJOdWRlIiwiIiwiMTAwRCIsIiIsIiIsIjEyODMxIiwiMjEzNDI4IiwiMjEzNDI4LTIwMDg1OCJd';

        // when
        $expected_value = [
            'name' => 'Soutien-Gorge Balconnet Chair',
            'slug' => 'soutien-gorge-balconnet-chair-5051928735753',
            'description' => '3Suisses :  77% Polyamide, 15% Polyester, 8% Elastane PRÉSENTATION La lemon team a sélectionné pour vous un incontournable à  avoir dans votre collection.Ce soutien-gorge peau de la ligne Marcie est parfait pour les poitrines généreuses. Il s\'adapte à  vos formes pour un rendu incomparable. Profond de bonnet, il permet de vous sentir à  l\'aise tout en ayant un rendu sensuel. Vous apprécierez d\'être bien dans votre lingerie, tout en restant irrésistiblement sexy. Ses armatures englobent votre poitrine et l\'entre-seins est assez grand pour que votre poitrine se place parfaitement bien dans votre soutien-gorge. Vous aurez une poitrine de rêve dans un soutien-gorge jeune, trendy et tout en finesse.De plus, un très joli tulle à  pois brodés donne un aspect dynamique et joliment raffiné. Votre silhouette est mise en valeur par le haut-bonnet brodé façon dentelle et un petit n?ud à  pois satiné cousu à  l\'entre-seins apportera une touche girly à  la pièce. Couleur chair, il sera parfait sous un t-shirt blanc. On ne s\'en lasse pas !   Venez vite découvrir l\'histoire du soutien-gorge !   Attention: Sur les soutien-gorges de la marque Panache, l\'étiquette textile indique la taille UK. DD=E; E=F; F=G; FF=H; G=I   ENTRETIEN Lavage main à  l\'eau tiède recommandé ou programme délicat en machine (30° max), dans un filet de protection.   CONSEIL STYLE Craquez pour le plumetis et lanez vous dans le nail art. CONSEIL TAILLE Tour de dos tonique, légèrement serré.  Marque: Cleo by Panache',
            'brand_original' => 'Cleo by Panache',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'vêtements et accessoires > vêtements > sous-vêtements et chaussettes > soutiens-gorges',
            'color_original' => 'nude',
            'price' => 30.1,
            'old_price' => 43.0,
            'reduction' => 30.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P510AB756823319S1UD41300b0250414V4',
            'image_url' => 'https://www.3suisses.fr/media/produits/cleo-by-panache/img/balconette-bra-cleo-by-panache-marcie-nude-47887_1200x1200.jpg',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '100D',
            'livraison' => '2-4',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Morgan()
    {
        $headers = 'EAN or ISBN,name of the product,internal reference,current price,crossed price,product category,product page URL,big image,manufacturer reference,brand,description,product availability,condition,shipping costs,ecotaxe,warranty,stock indicator,performance indicator,discount indicator,Tailles,Couleurs';

        // given
        $payload = 'WyIzMjUzNjMwOTUyOTUwIiwiUHVsbCBtYW5jaGVzIGxvbmd1ZXMgY29sIHJvdWxcdTAwZTkgZ3JpcyBhbnRocmFjaXRlIGZlbW1lIiwiMzI1MzYzMDk1Mjk1MCIsIjI1IiwiIiwiVlx1MDBlYXRlbWVudHMgPiBQdWxscyA+IFB1bGxzIGNvbHMgcm91bFx1MDBlOXMiLCJodHRwczpcL1wvYWN0aW9uLm1ldGFmZmlsaWF0aW9uLmNvbVwvdHJrLnBocD9tY2xpYz1QNDNCNDM1NjgyMzMyMkJTMVVENDEyODk1MDExNTM0MVY0IiwiaHR0cHM6XC9cL3d3dy5tb3JnYW5kZXRvaS5mclwvb25cL2RlbWFuZHdhcmUuc3RhdGljXC8tXC9TaXRlcy1Nb3JnYW5fbWFzdGVyXC9kZWZhdWx0XC9kd2E4Y2U0MTg3XC9wdWxsLW1hbmNoZXMtbG9uZ3Vlcy1jb2wtcm91bGUtZ3Jpcy1hbnRocmFjaXRlLWZlbW1lLW9yLTMyNTM2MzAwNDU5NzkwMTAzLmpwZyIsIiIsIk1vcmdhbiIsIjx1bD5QdWxsIG1hbmNoZXMgbG9uZ3VlcyBjb2wgcm91bFx1MDBlOTxiclwvPkNvdXBlIGFqdXN0XHUwMGU5ZTxiclwvPkNvbCByb3VsXHUwMGU5PGJyXC8+TWFuY2hlcyBsb25ndWVzPGJyXC8+TWFpbGxlIGZpbmU8YnJcLz5EXHUwMGU5dGFpbHMgZW4gbWFpbGxlIGNcdTAwZjR0ZWxcdTAwZTllPGJyXC8+TGUgbWFubmVxdWluIG1lc3VyZSAxbTc1IGV0IHBvcnRlIHVuZSB0YWlsbGUgU1wvMzY8YnJcLz5Db25zZWlsIHRhaWxsZSA6IGNob2lzaXNzZXogdm90cmUgdGFpbGxlIGhhYml0dWVsbGU8YnJcLz5SXHUwMGU5Zlx1MDBlOXJlbmNlIDogMTMyLU1FTlRPUy5NPFwvdWw+IiwiIiwibmV3IiwiIiwiIiwiIiwiIiwiIiwiIiwiTCIsIkdSSVMgQU5USFJBQ0lURSJd';

        // when
        $expected_value = [
            'name' => 'Pull manches longues col roulé',
            'slug' => 'pull-manches-longues-col-roul-gris-anthracite-femme-3253630952950',
            'description' => 'Pull manches longues col rouléCoupe ajustéeCol rouléManches longuesMaille fineDétails en maille côteléeLe mannequin mesure 1m75 et porte une taille S/36Conseil taille : choisissez votre taille habituelleRéférence : 132-MENTOS.M',
            'brand_original' => 'Morgan',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'vêtements > pulls > pulls cols roulés',
            'color_original' => 'gris anthracite',
            'price' => 25.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P43B4356823322BS1UD4128950115341V4',
            'image_url' => 'https://www.morgandetoi.fr/on/demandware.static/-/Sites-Morgan_master/default/dwa8ce4187/pull-manches-longues-col-roule-gris-anthracite-femme-or-32536300459790103.jpg',
            'gender' => 'femme',
            'col' => 'col roulé',
            'coupe' => 'coupe ajustée',
            'manches' => 'manches longues',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'L',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Minelli()
    {
        $headers = 'Nom,reference interne,prix actuel,categorie,URLproduit,MPN,marque,EAN,frais de port,descriptif,garantie,indicateur de stock,disponibilite,indicateur de performance,indicateur de promotion,indicateur de nouveaute,URL image petite,URL image moyenne,URL image grande,ecotaxe,prix barre,genre,Categorie_finale,Debut de Remise,Fin de remise,Taille,Famille de produit,Couleur,Délai de livraison,Matière';

        $payload = 'WyJCb290cyAtIEZsZXVyIiwiNzgzNzY4OTkiLCIxMzkuMDAiLCJCT09UUyIsImh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA0OERCRjU2ODIzMzIyNVMxVUQ0MTI4YTEwMTU1NTc2VjQiLCIiLCJNaW5lbGxpIiwiMzYxMDI3MjI4MTg0NiIsIk9mZmVydCIsIkplIG0nYXBwZWxsZSBGbGV1ciNCb290cyBlbiBjdWlyIGxpc3NlI0VsYXN0aXF1ZSBzdXIgbGUgY1x1MDBmNHRcdTAwZTkiLCIiLCIzIiwiaW4gc3RvY2siLCIiLCIiLCIiLCIiLCJodHRwczpcL1wvd3d3Lm1pbmVsbGkuZnJcL2R3XC9pbWFnZVwvdjJcL0JDTEJfUFJEXC9vblwvZGVtYW5kd2FyZS5zdGF0aWNcLy1cL1NpdGVzLU1JTi1tYXN0ZXItY2F0YWxvZ1wvZGVmYXVsdFwvXC9pbWFnZXNcL0Y4MDcyOF9OT0lSX0IuanBnIiwiaHR0cHM6XC9cL3d3dy5taW5lbGxpLmZyXC9kd1wvaW1hZ2VcL3YyXC9CQ0xCX1BSRFwvb25cL2RlbWFuZHdhcmUuc3RhdGljXC8tXC9TaXRlcy1NSU4tbWFzdGVyLWNhdGFsb2dcL2RlZmF1bHRcL1wvaW1hZ2VzXC9GODA3MjhfTk9JUl9BLmpwZyIsIiIsIjEzOS4wMCIsIkZlbW1lIiwiNDIwIiwiIiwiIiwiNDEiLCJST1VNQU5JRSIsIk5PSVIiLCJzb3VzIDUgXHUwMGUwIDYgam91cnMiLCJDVUlSIFZFQVUiXQ==';

        $expected_value = [
            'name' => 'Boots - Fleur',
            'slug' => 'boots-fleur-78376899',
            'description' => 'Je m\'appelle Fleur#Boots en cuir lisse#Elastique sur le côté',
            'brand_original' => 'Minelli',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'boots',
            'color_original' => 'noir',
            'price' => 139.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P48DBF568233225S1UD4128a10155576V4',
            'image_url' => 'https://www.minelli.fr/dw/image/v2/BCLB_PRD/on/demandware.static/-/Sites-MIN-master-catalog/default//images/F80728_NOIR_A.jpg',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'cuir veau',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '41',
            'livraison' => 'sous 5 à 6 jours',
        ];

        $this->markTestIncomplete('need new payload to avoid DB connection on Category resolve');

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Arthur()
    {
        $headers = 'id,title,link,price,description,condition,gtin,brand,mpn,image_link,product_type,availability,shipping,shipping_weight,google_product_category,adwords_grouping,adwords_labels,gender,age_group,color,size,item_group_id,sale_price,adwords_redirect,identifier_exists,sale_price_effective_date,tax,custom_label_0,custom_label_1,custom_label_2,custom_label_3,custom_label_4,adult,promotion_id,shipping_length,shipping_width,shipping_height,shipping_label,additional_image_link,mobile_link,is_bundle,material,display_ads_link,display_ads_title,excluded_destination,display_ads_value,pattern,installment,loyalty_points,size_type,size_system,cross_sellers_product_id,multipack,availability_date,unit_pricing_measure,unit_pricing_base_measure,display_ads_id,min_handling_time,max_handling_time,sell_on_google_quantity,energy_efficiency_class,min_energy_efficiency_class,max_energy_efficiency_class,product_fee,product_detail,consumer_datasheet,return_address_label,return_policy_label,google_funded_promotion_eligibility,signature_required,return_rule_label';

        $payload = 'WyJUUElVTklIMTctTUFSSU5FLVMiLCJUZWUtc2hpcnQgcGltYSBtYXJpbmUiLCJodHRwczpcL1wvanJ0LmJvdXRpcXVlLWFydGh1ci5jb21cLz9QNEZGNDU1NjgyMzMxN1MxVUI0MTJkNTkwNzM4MFY0IiwiMzkuMDAiLCJUZWUtc2hpcnQgbWFuY2hlcyBjb3VydGVzIGNvbCByb25kLCAxMDAgJSBjb3RvbiBwaW1hIChtZWlsbGV1cmUgcXVhbGl0XHUwMGU5IGRlIGNvdG9uKSIsIm5ldyIsIjMzNjk2OTI2MDAyODYiLCJBcnRodXIiLCJNUE5fVFBJVU5JSDE3LU1BUklORS1TIiwiaHR0cHM6XC9cL2Nkbi5zaG9waWZ5LmNvbVwvc1wvZmlsZXNcLzFcLzAwMTVcLzMwODhcLzgyNDVcL3Byb2R1Y3RzXC9UUElVTklIMTdfbWFyaW5lLWEuanBnIiwiVGVlIFNoaXJ0cyIsImluIHN0b2NrIiwiMyIsIjAiLCJWXHUwMGVhdGVtZW50cyBldCBhY2Nlc3NvaXJlcyA+IFZcdTAwZWF0ZW1lbnRzID4gSGF1dHMiLCJUZWUgU2hpcnRzIiwiVFBJVU5JSDE3LU1BUklORS1TIiwibWFsZSIsImFkdWx0IiwiTUFSSU5FIiwiUyIsIjE0Mzc3ODcyOTE3MDEiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDAxNVwvMzA4OFwvODI0NVwvcHJvZHVjdHNcL1RQSVVOSUgxN19tYXJpbmUtYS5qcGcsaHR0cHM6XC9cL2Nkbi5zaG9waWZ5LmNvbVwvc1wvZmlsZXNcLzFcLzAwMTVcLzMwODhcLzgyNDVcL3Byb2R1Y3RzXC9UUElVTklIMTdfbWFyaW5lLTEuanBnIiwiIiwiRkFMU0UiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCIiLCI0IiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIl0=';

        $expected_value = [
            'name' => 'Tee-shirt pima marine',
            'slug' => 'tee-shirt-pima-marine-3369692600286',
            'description' => 'Tee-shirt manches courtes col rond, 100 % coton pima (meilleure qualité de coton)',
            'brand_original' => 'Arthur',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'tee shirts|vêtements et accessoires > vêtements > hauts',
            'color_original' => 'marine',
            'price' => 39.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://jrt.boutique-arthur.com/?P4FF4556823317S1UB412d5907380V4',
            'image_url' => 'https://cdn.shopify.com/s/files/1/0015/3088/8245/products/TPIUNIH17_marine-a.jpg',
            'gender' => 'homme',
            'col' => 'col rond',
            'coupe' => '',
            'manches' => 'manches courtes',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'S',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Ambazad()
    {
        $headers = 'EAN,name,sku,sale-price,regular-price,category-breadcrumb,url,image-url,supplier-sku,brand,description,shipping-cost,ecotax,warranty,availability,restocking-delay,performance-score,discount-type,is-new,color,heel-size,shaft-material,outside-sole-material,inside-sole-material,lining-material,footwear,style';

        $payload = 'WyIwNjM4NjAxMDIwMDA2IiwiVHJhbSBOb2lyIiwiMDYzODYwMSIsIjM5Ljk2IiwiOTkuOTAiLCJGZW1tZSA+IFNhbmRhbGVzICYgbnUtcGllZHMiLCJodHRwczpcL1wvYWN0aW9uLm1ldGFmZmlsaWF0aW9uLmNvbVwvdHJrLnBocD9tY2xpYz1QNEIyM0I1NjgyMzMyMjFTMVU4NDEyODI3MDFWNCIsImh0dHA6XC9cL3d3dy5hbWJhemFkLmZyXC9tZWRpYVwvY2F0YWxvZ1wvcHJvZHVjdFwvMFwvNlwvMDYzODYwMV8wMS5qcGciLCIiLCJGbHkgTG9uZG9uIiwiQ2hhdXNzdXJlc2ZlbW1lIGRlIGxhIG1hcnF1ZSBGbHkgTG9uZG9uLiBNb2RcdTAwZThsZSBUcmFtIiwiNi45NSIsIjAuMDAiLCIwIiwiMSIsIjAiLCIxMCIsIjMiLCIwIiwiTm9pciIsIkNvbXBlbnNcdTAwZTkiLCJDdWlyIiwiR29tbWUiLCJDdWlyIiwiQ3VpciIsIk5vcm1hbCIsIiJd';

        $expected_value = [
            'name' => 'Tram Noir',
            'slug' => 'tram-noir-0638601020006',
            'description' => 'Chaussuresfemme de la marque Fly London. Modèle Tram',
            'brand_original' => 'Fly London',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'femme > sandales & nu-pieds',
            'color_original' => 'noir',
            'price' => 39.96,
            'old_price' => 99.9,
            'reduction' => 60.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4B23B568233221S1U841282701V4',
            'image_url' => 'http://www.ambazad.fr/media/catalog/product/0/6/0638601_01.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'gomme',
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

    public function test__parse_row__from_Deeluxe()
    {
        $headers = 'nom,référence interne,prix actuel,catégorie,URL de la page produit,modèle,marque,référence universelle,référence constructeur,frais de ports,descriptif,garantie,indicateur de stock,disponibilité,indicateur de performance,indicateur promotion,indicateur nouveauté,URL image petite,URL image moyenne,URL image grande,écotaxe,Matière,prix barre';

        $payload = 'WyJCT05ORVQgSEFST0xEIC0gQ291bGV1ciAtIE1lZGl1bSBHcmV5IE1lbCwgVGFpbGxlIC0gVFUiLCIyNjAyMV85NDgxMiIsIjcuOTkiLCJBY2N1ZWlsID4gSE9NTUUgPiBBY2Nlc3NvaXJlIiwiaHR0cHM6XC9cL2FjdGlvbi5tZXRhZmZpbGlhdGlvbi5jb21cL3Ryay5waHA/bWNsaWM9UDREMDk5NTY4MjMzMURTMVVDNDEyOWM3MDI4NzM5VjQiLCIiLCIiLCIzNjE2MzIwMjE3ODY3IiwiVzIwOTIzTU1FRF9UVSIsIjQuOTAiLCJIQVJPTEQgZXN0IGxlIGJvbm5ldCBcdTAwZTAgcG9ydGVyIHRvdXMgbGVzIGpvdXJzICEgRmFjaWxlIFx1MDBlMCBhc3NvcnRpciwgYWdyXHUwMGU5YWJsZSBcdTAwZTAgcG9ydGVyLCBpbCBkZXZpZW50IHVuIGluZGlzcGVuc2FibGUgZHUgZHJlc3NpbmcgbWFzY3VsaW4gYXZlYyBzb24gbG9nbyBlbiByZWxpZWYgc3VyIGxlIGRldmFudC4gTGEgbWFpbGxlIGNoaW5cdTAwZTllIGRlIGNlIGJvbm5ldCBwb3VyIGhvbW1lIGFwcG9ydGUgdW5lIHBldGl0ZSB0b3VjaGUgdmludGFnZS4iLCIiLCIzNyIsIiIsIiIsIiIsIiIsIiIsIiIsImh0dHBzOlwvXC93d3cuZGVlbHV4ZS5mclwvNTUwNTAtdGhpY2tib3hfZGVmYXVsdFwvaGFyb2xkLmpwZyIsIiIsIkFjcnlsaXF1ZSIsIjcuOTkiXQ==';

        $expected_value = [
            'name' => 'BONNET HAROLD - Couleur - Medium Grey Mel, Taille - TU',
            'slug' => 'bonnet-harold-couleur-medium-grey-mel-taille-tu-26021_94812',
            'description' => 'HAROLD est le bonnet à porter tous les jours ! Facile à assortir, agréable à porter, il devient un indispensable du dressing masculin avec son logo en relief sur le devant. La maille chinée de ce bonnet pour homme apporte une petite touche vintage.',
            'brand_original' => 'Source Name',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'accueil > homme > accessoire',
            'color_original' => '',
            'price' => 7.99,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4D0995682331DS1UC4129c7028739V4',
            'image_url' => 'https://www.deeluxe.fr/55050-thickbox_default/harold.jpg',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'acrylique',
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

    public function test__parse_row__from_Maisonbaum()
    {
        $headers = 'title,currency,image_url,product_url,original_price,price,availability,color,description,brand,condition,gtin,model,size,sku,stock,categories,subcategories,weight,additional_image_link,attribute_title';

        $payload = 'WyJNYWlzb24gQmF1bSBTdGlsZXR0byBBbWJyb3NpYSBDaFx1MDBlOHZyZSBWZWxvdXJzIFZlcnQgMzkuNSIsIiIsImh0dHBzOlwvXC9jZG4uc2hvcGlmeS5jb21cL3NcL2ZpbGVzXC8xXC8wMDE0XC8zNzg5XC8yNjk1XC9wcm9kdWN0c1wvbWFpc29uYmF1bV9hbWJyb3NpYV8wX2gwMDNzdTIwMF9wcm9maWwxLmpwZz92PTE2MDcxODQwMTkiLCJodHRwczpcL1wvcWR0Lm1haXNvbmJhdW0uY29tXC8/UDUxMEVEMzU2ODIzMzIxM1MxVTk0MTMyMDkwNTFWNCIsIiIsIjI2NS4wMCIsIlllcyIsIkNoXHUwMGU4dnJlIFZlbG91cnMgVmVydCIsIjxoNT5SXHUwMGNhVlx1MDBjOSBcdTAwYzAgUEFSSVMuIERcdTAwYzlWRUxPUFBcdTAwYzkgXHUwMGMwIEJFUkxJTi4gRkFCUklRVVx1MDBjOSBBVSBQT1JUVUdBTC48XC9oNT48ZGl2IGNsYXNzPVwidGV4dC13cmFwIHRsaWQtY29weS10YXJnZXRcIj48ZGl2IGNsYXNzPVwidGV4dC13cmFwIHRsaWQtY29weS10YXJnZXRcIj48ZGl2IGNsYXNzPVwicmVzdWx0LXNoaWVsZC1jb250YWluZXIgdGxpZC1jb3B5LXRhcmdldFwiIHRhYmluZGV4PVwiMFwiPjxwPjxzcGFuPkF2ZWMgc2Egc2VtZWxsZSBpbnRcdTAwZTlyaWV1cmUgYnJldmV0XHUwMGU5ZSwgbGUgZmFidWxldXggc3RpbGV0dG8gZGUgMTAgY20sIEFtYnJvc2lhIGFmZmlybWVyYSB2b3RyZSBcdTAwZTlsXHUwMGU5Z2FuY2UsIHRvdXQgZW4gY29uZm9ydC4gRmFicmlxdVx1MDBlOSBkZSBtYW5pXHUwMGU4cmUgcmVzcG9uc2FibGUsIGNcdTIwMTllc3QgdW4gdGFsb24gaGF1dCBcdTAwZTlwdXJcdTAwZTkgZXQgdGVsbGVtZW50IGZcdTAwZTltaW5pbiBxdVx1MjAxOWlsIG5lIHBvdXJyYSBsYWlzc2VyIGluZGlmZlx1MDBlOXJlbnQgYXV0b3VyIGRlIHZvdXMuQ29tcHJlbmQgZGV1eCBwYWlyZXMgZGUgc2FuZ2xlcyBkZSByZXRlbnVlLjxcL3NwYW4+PFwvcD48cD48c3BhbiBjbGFzcz1cImdlcm1hbi1wZHAtdmlkZW9cIj48aWZyYW1lIHdpZHRoPVwiNTYwXCIgaGVpZ2h0PVwiMzE1XCIgc3JjPVwiaHR0cHM6XC9cL3d3dy55b3V0dWJlLmNvbVwvZW1iZWRcL0xVM3dTWXRsSmowXCIgZnJhbWVib3JkZXI9XCIwXCIgYWxsb3c9XCJhY2NlbGVyb21ldGVyOyBhdXRvcGxheTsgZW5jcnlwdGVkLW1lZGlhOyBneXJvc2NvcGU7IHBpY3R1cmUtaW4tcGljdHVyZVwiIGFsbG93ZnVsbHNjcmVlbj48XC9pZnJhbWU+PFwvc3Bhbj48XC9wPjxwPiA8XC9wPjxwPjxzcGFuIGNsYXNzPVwiZW5nbGlzaC1wZHAtdmlkZW9cIj48aWZyYW1lIHdpZHRoPVwiNTYwXCIgaGVpZ2h0PVwiMzE1XCIgc3JjPVwiaHR0cHM6XC9cL3d3dy55b3V0dWJlLmNvbVwvZW1iZWRcL05hX3JBSUI2WXJZXCIgZnJhbWVib3JkZXI9XCIwXCIgYWxsb3c9XCJhY2NlbGVyb21ldGVyOyBhdXRvcGxheTsgZW5jcnlwdGVkLW1lZGlhOyBneXJvc2NvcGU7IHBpY3R1cmUtaW4tcGljdHVyZVwiIGFsbG93ZnVsbHNjcmVlbj48XC9pZnJhbWU+PFwvc3Bhbj48XC9wPjxwPiA8XC9wPjxwPjxzcGFuIGNsYXNzPVwiZnJlbmNoLXBkcC12aWRlb1wiPjxpZnJhbWUgd2lkdGg9XCI1NjBcIiBoZWlnaHQ9XCIzMTVcIiBzcmM9XCJodHRwczpcL1wvd3d3LnlvdXR1YmUuY29tXC9lbWJlZFwvMUVMcnJROGVpcHNcIiBmcmFtZWJvcmRlcj1cIjBcIiBhbGxvdz1cImFjY2VsZXJvbWV0ZXI7IGF1dG9wbGF5OyBlbmNyeXB0ZWQtbWVkaWE7IGd5cm9zY29wZTsgcGljdHVyZS1pbi1waWN0dXJlXCIgYWxsb3dmdWxsc2NyZWVuPjxcL2lmcmFtZT48XC9zcGFuPjxcL3A+PHA+IDxcL3A+PHNwYW4gY2xhc3M9XCJ0bGlkLXRyYW5zbGF0aW9uIHRyYW5zbGF0aW9uXCIgbGFuZz1cImRlXCI+PHNwYW4gdGl0bGU9XCJcIiBjbGFzcz1cIlwiPjxcL3NwYW4+PFwvc3Bhbj48c3BhbiBjbGFzcz1cInRsaWQtdHJhbnNsYXRpb24tZ2VuZGVyLWluZGljYXRvciB0cmFuc2xhdGlvbi1nZW5kZXItaW5kaWNhdG9yXCI+PFwvc3Bhbj48XC9kaXY+PFwvZGl2Pjx1bD48XC91bD48XC9kaXY+IiwiTWFpc29uIEJhdW0iLCJuZXciLCI0MjYwNjY5NTEwNjc4IiwiYW1icm9zaWEtMTBjbSIsIjM5LjUiLCJIMDAzU1UyMDBfMzk1IiwiNDkuMCIsInNob2VzIiwiU3RpbGV0dG8iLCIwLjlrZyIsImh0dHBzOlwvXC9jZG4uc2hvcGlmeS5jb21cL3NcL2ZpbGVzXC8xXC8wMDE0XC8zNzg5XC8yNjk1XC9wcm9kdWN0c1wvbWFpc29uYmF1bV9hbWJyb3NpYV8wX2gwMDNzdTk5OV9wcm9maWwxLmpwZz92PTE2MDcxNjE2MTEiLCIzOS41IFwvIENoXHUwMGU4dnJlIFZlbG91cnMgVmVydCJd';

        $expected_value = [
            'name' => 'Stiletto Ambrosia 39.5',
            'slug' => 'maison-baum-stiletto-ambrosia-ch-vre-velours-vert-39-5-4260669510678',
            'description' => 'RÊVÉ À PARIS. DÉVELOPPÉ À BERLIN. FABRIQUÉ AU PORTUGAL.Avec sa semelle intérieure brevetée, le fabuleux stiletto de 10 cm, Ambrosia affirmera votre élégance, tout en confort. Fabriqué de manière responsable, c’est un talon haut épuré et tellement féminin qu’il ne pourra laisser indifférent autour de vous.Comprend deux paires de sangles de retenue.',
            'brand_original' => 'Maison Baum',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'shoes|stiletto',
            'color_original' => 'chèvre velours vert',
            'price' => 265.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://qdt.maisonbaum.com/?P510ED3568233213S1U9413209051V4',
            'image_url' => 'https://cdn.shopify.com/s/files/1/0014/3789/2695/products/maisonbaum_ambrosia_0_h003su200_profil1.jpg?v=1607184019',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => 'ambrosia-10cm',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '39.5',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Zaful()
    {
        $headers = '"Universal reference",Product Name,Internal reference,Current Price,Crossed Price,Product category,Product page URL,URL of the big image,Name of brand,Discription of the product,Shipping cost,Stock indicator,New indicator,Color,Size';

        $payload = 'WyIyODEwNjEzMDEiLCJTd2VhdCBcdTAwZTAgQ2FwdWNoZSBGb3Vyclx1MDBlOSBlbiBDb3VsZXVyIFVuaWUgYXZlYyBQb2NoZSBNIEJsYW5jIGNoYXVkIiwiNTY2MzQ2IiwiMjMuNDciLCI0MC40OSIsIkhvbW1lID4gSGF1dHMgUG91ciBIb21tZSA+IFN3ZWF0LXNoaXJ0cyIsImh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA0REUzMzU2ODIzMzFCUzFVRTQxMjVmNTAxNjk2ODc1VjQiLCJodHRwczpcL1wvZ2xvaW1nLnphZmNkbi5jb21cL3phZnVsXC9wZG0tcHJvZHVjdC1waWNcL0Nsb3RoaW5nXC8yMDE4XC8wOVwvMDNcL3NvdXJjZS1pbWdcLzIwMTgwOTAzMTU0MzQ3XzE5OTIzLmpwZyIsIlpBRlVMIiwiWmFmdWwgIFN3ZWF0IFx1MDBlMCBjYXB1Y2hlIHNvbGlkZSBhdmVjIGNvcmRvbiBhanVzdGFibGUgZXQgbWFuY2hlcyBsb25ndWVzLiBEb3RcdTAwZTkgZCd1biBkdXZldCBkb3V4LCBkJ3VuZSBwb2NoZSBrYW5nb3Vyb3Ugc3VyIGxlIGRldmFudCwgZGUgZFx1MDBlOXRhaWxzIHN1ciBsYSBtYW5jaGUgZXQgZGUgcG9pZ25ldHMgY1x1MDBmNHRlbFx1MDBlOXMuIFR5cGUgZGUgVlx1MDBlYXRlbWVudDogU3dlYXQgXHUwMGUwIENhcHVjaGUgU3R5bGU6IFx1MDBlMCBsYSBNb2RlIFR5cGUgZGUgTW90aWY6IFBhdGNod29yayxDb3VsZXVyIFB1cmUgTWF0aVx1MDBlOHJlczogUG9seWVzdGVyIFx1MDBjOSIsIiIsIjEiLCIxIiwiQmxhbmMgQ2hhdWQiLCJNIl0=';

        $expected_value = [
            'name' => 'Sweat à Capuche Fourré en Couleur Unie avec Poche M',
            'slug' => 'sweat-capuche-fourr-en-couleur-unie-avec-poche-m-blanc-chaud-566346',
            'description' => 'Zaful  Sweat à capuche solide avec cordon ajustable et manches longues. Doté d\'un duvet doux, d\'une poche kangourou sur le devant, de détails sur la manche et de poignets côtelés. Type de Vêtement: Sweat à Capuche Style: à la Mode Type de Motif: Patchwork,Couleur Pure Matières: Polyester É',
            'brand_original' => 'Source Name',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'homme > hauts pour homme > sweat-shirts',
            'color_original' => 'blanc chaud',
            'price' => 23.47,
            'old_price' => 40.49,
            'reduction' => 42.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4DE335682331BS1UE4125f501696875V4',
            'image_url' => 'https://gloimg.zafcdn.com/zaful/pdm-product-pic/Clothing/2018/09/03/source-img/20180903154347_19923.jpg',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => 'manches longues',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'M',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Ripauste()
    {
        $headers = 'Nom,R_f_rence Interne,Montant (TTC),Montant (TTC),Cat_gorie Fil d\'ariane,URL de la page,URL Image,R_f_rence fabricant,Nom de la marque,Description';

        $payload = 'WyJDZWludHVyZSBlbiBjdWlyIHRyZXNzXyBjb3JhaWwiLCIyOTEiLCIgMzksMDAgIFx1MDA5NyAiLCIgMzksMDAgIFx1MDA5NyAiLCJBY2N1ZWlsPkUtQk9VVElRVUU+QUNDRVNTT0lSRVMiLCJodHRwczpcL1wvZXhwLnJpcGF1c3RlLmZyXC8/UDUxMTQxMzU2ODIzMzE1UzFVQTQxMzFjNTAxNzlWNCIsImh0dHBzOlwvXC9yaXBhdXN0ZS5mclwvMTczOVwvY2VpbnR1cmUtZW4tY3Vpci10cmVzc2UtY29yYWlsLmpwZyIsIlJJUDI5MSIsIlJJUEFVU1RFIiwiQ2VpbnR1cmUgZW4gQ3Vpclx1MDBjYUNvcmFpbFZvdXMgXHUwMDkwdGVzIFx1MDA4OCBsYSByZWNoZXJjaGUgZCd1bmUgY2VpbnR1cmUgdG91dGUgZmluZSBwb3VyIHJlbGV2ZXIgZGlzY3JcdTAwOGZ0ZW1lbnQgdm90cmUgdGVudWU/IEplIHN1aXMgc3VyZSBxdWUgbGUgbW9kXHUwMDhmbGUgZW4gY3VpciBcImZhXHUwMDhkb25cIiB0cmVzc1x1MDA4ZSBSaXBhdXN0ZSB2b3VzIHBsYWlyYS5MXHUwMDhlZ1x1MDA4ZnJlIGF2ZWMgYmVhdWNvdXAgZGUgY2FyYWN0XHUwMDhmcmUgY2UgbW9kXHUwMDhmbGUgZW4gY3VpciBwbGVpbmUgZmxldXIgc2F1cmEgdm91cyBzXHUwMDhlZHVpcmUuQ290XHUwMDhlIGNvdWxldXIsIG9wdGV6IHNhbnMgaFx1MDA4ZXNpdGVyIHBvdXIgbGUgY29sb3JpcyBjb3JhaWwgcXVpIGFwcG9ydGVyYSB1biB2ZW50IGRlIGZyYWljaGV1ciBcdTAwODggdG91cyB2b3MgbG9va3MuRGltZW5zaW9ucyA6ICBMYXJnZXVyIDogMSw5IGNtICBMb25ndWV1ciA6IDEwNSBjbUxlcyBQZXRpdHMgcGx1cyBkZSBsYSBDZWludHVyZSBlbiBDdWlyIFJpcGF1c3RlIDogIENlaW50dXJlIHJcdTAwOGVnbGFibGUgKDcgcG9zaXRpb25zKSAgQm91Y2xlIEFyZ2VudFx1MDA4ZWVNYXRpXHUwMDhmcmUgOiAgMTAwJSBDdWlyIFBsZWluZSBGbGV1ciJd';

        $expected_value = [
            'name' => 'Ceinture en cuir tress_ corail',
            'slug' => 'ceinture-en-cuir-tress_-corail-291',
            'description' => 'Ceinture en CuirÊCorailVous tes  la recherche d\'une ceinture toute fine pour relever discrtement votre tenue? Je suis sure que le modle en cuir "faon" tress Ripauste vous plaira.Lgre avec beaucoup de caractre ce modle en cuir pleine fleur saura vous sduire.Cot couleur, optez sans hsiter pour le coloris corail qui apportera un vent de fraicheur  tous vos looks.Dimensions :  Largeur : 1,9 cm  Longueur : 105 cmLes Petits plus de la Ceinture en Cuir Ripauste :  Ceinture rglable (7 positions)  Boucle ArgenteMatire :  100% Cuir Pleine Fleur',
            'brand_original' => 'RIPAUSTE',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'accueil>e-boutique>accessoires',
            'color_original' => '',
            'price' => 39.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://exp.ripauste.fr/?P51141356823315S1UA4131c50179V4',
            'image_url' => 'https://ripauste.fr/1739/ceinture-en-cuir-tresse-corail.jpg',
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

    public function test__parse_row__from_LovelyDay()
    {
        $headers = 'id,title,brand,description,price,sale_price,link,image_link,condition,availability,google_product_category,identifier_exists,gtin,shipping_weight,custom_label_0,custom_label_1,custom_label_2,custom_label_3,item_group_id,color,size,material,gender,age_group';

        $payload = 'WyIyMDQiLCJDclx1MDBlOW9sZXMgTXljXHUwMGU4bmVzIEdyYW5kZSBST1NFIERFUyBWRU5UUyIsIkxvdmVseSBEYXkgQmlqb3V4IiwiVGFsaXNtYW4gTXljXHUwMGU4bmVzIFJPU0UgREVTIFZFTlRTIERvclx1MDBlOSIsIjExNC4wMCBFVVIiLCIxMTQuMDAgRVVSIiwiaHR0cHM6XC9cL2phei5sb3ZlbHlkYXliaWpvdXguY29tXC8/UDUxMTQwRjU2ODIzMzE1UzFVQTQxMzFiNTA4OTNWNCIsImh0dHBzOlwvXC93d3cubG92ZWx5ZGF5Ymlqb3V4LmNvbVwvbWVkaWFcL2NhY2hlXC9nb29nbGVfZmVlZF9wcm9kdWN0XC8yMDE5XC8xMFwvOTk3Mi1jcmVvbGVzLWZhbnRhaXNpZS1teWNlbmVzLW9yLXJvc2UtZGVzLXZlbnRzLWdtLWxvdmVseWRheS1sb2QwMTgxMjcuanBnIiwibmV3IiwiaW4gc3RvY2siLCJWXHUwMGVhdGVtZW50cyBldCBhY2Nlc3NvaXJlcyA+IEJpam91eCA+IEJvdWNsZXMgZCdvcmVpbGxlcyIsIm5vIiwiIiwiMCBrZ3MiLCIiLCIiLCIiLCJMT0QwMTgxMjciLCIiLCIiLCIiLCIiLCIiLCJhZHVsdCJd';

        $expected_value = [
            'name' => 'Créoles Mycènes Grande ROSE DES VENTS',
            'slug' => 'cr-oles-myc-nes-grande-rose-des-vents-204',
            'description' => 'Talisman Mycènes ROSE DES VENTS Doré',
            'brand_original' => 'Lovely Day Bijoux',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'vêtements et accessoires > bijoux > boucles d\'oreilles',
            'color_original' => '',
            'price' => 114.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://jaz.lovelydaybijoux.com/?P51140F56823315S1UA4131b50893V4',
            'image_url' => 'https://www.lovelydaybijoux.com/media/cache/google_feed_product/2019/10/9972-creoles-fantaisie-mycenes-or-rose-des-vents-gm-lovelyday-lod018127.jpg',
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

    public function test__parse_row__from_JackWolfskin()
    {
        $headers = 'Id,EAN,Original Herstellerartikelnummer,item_group_id,title,short_description,description,link,mobile_link,price_old,price,currency,sale,brand,condition,image_link,additional_image_link,product_type,color,size,availability,gtin,manufacturer,gender,age_group,keywords,material,shipping,delivery_period,shipping_kreditkarte,shipping_paypal,shipping_sofortbanking,shipping_rechnung,shipping_click_collect,shipping_geschenkkarte,shipping_kommentar,Rücksendung,mpn,seo_name,Gutschein,Gutscheincode,Highlights';

        $payload = 'WyIxMTEyOTExLTUwNjQwMDMiLCI0MDYwNDc3NDY1NzYwIiwiMTExMjkxMS01MDY0MDAzIiwiMTExMjkxMSIsIkphY2sgV29sZnNraW4gVmVzdGUgaGFyZHNoZWxsIGhvbW1lcyBLYXJvbyBKYWNrZXQgTWVuIE0gbWFycm9uIHNhaGFyYSBzYW5kIiwiIiwiVmVzdGUgaW1wZXJtXHUwMGU5YWJsZSwgcmVzcGlyYW50ZSBhdmVjIG1hbmNoZXMgYW1vdmlibGVzIHBvdXIgdW4gbG9vayAyIGVuIDEuIiwiaHR0cHM6XC9cL2FjdGlvbi5tZXRhZmZpbGlhdGlvbi5jb21cL3Ryay5waHA/bWNsaWM9UDUxMEZCQjU2ODIzMzE1UzFVQTQxMzEyZDA2ODBWNCIsImh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA1MTBGQkI1NjgyMzMxNVMxVUE0MTMxMmQwNjgwVjQiLCIzOTkuOTUiLCIxOTkuOTUiLCJFVVIiLCJ5ZXMiLCJKYWNrIFdvbGZza2luIiwibmV3IiwiaHR0cHM6XC9cL3d3dy5qYWNrLXdvbGZza2luLmZyXC9sXC9pbWFnZVwvcHJvZHVjdD9waWQ9MTExMjkxMS01MDY0MDAzJndpZHRoPTEwMDAmZm9ybWF0PWpwZyZpbmRleD0wIiwiaHR0cHM6XC9cL3d3dy5qYWNrLXdvbGZza2luLmZyXC9sXC9pbWFnZVwvcHJvZHVjdD9waWQ9MTExMjkxMS01MDY0MDAzJndpZHRoPTEwMDAmZm9ybWF0PWpwZyZpbmRleD0xLGh0dHBzOlwvXC93d3cuamFjay13b2xmc2tpbi5mclwvbFwvaW1hZ2VcL3Byb2R1Y3Q/cGlkPTExMTI5MTEtNTA2NDAwMyZ3aWR0aD0xMDAwJmZvcm1hdD1qcGcmaW5kZXg9MixodHRwczpcL1wvd3d3LmphY2std29sZnNraW4uZnJcL2xcL2ltYWdlXC9wcm9kdWN0P3BpZD0xMTEyOTExLTUwNjQwMDMmd2lkdGg9MTAwMCZmb3JtYXQ9anBnJmluZGV4PTMiLCJIb21tZXMgPiBQcm9kdWl0cyBwaGFyZXMgPiBXb2xmc2tpbiBURUNIIExBQiA+IFZlc3RlIGhhcmRzaGVsbCBob21tZXMiLCJzYWhhcmEgc2FuZCIsIk0iLCJpbiBzdG9jayIsIjQwNjA0Nzc0NjU3NjAiLCJKQUNLIFdPTEZTS0lOIiwiTWFsZSIsImFkdWx0IiwiV29sZnNraW4gVEVDSCBMQUIgVmVzdGUgaGFyZHNoZWxsIGhvbW1lcyIsIiIsIkZSIERITCBTdGFuZGFyZCAwLjAwIiwiMyBcdTAwZTAgNCBqb3VycyIsIjAuMDAiLCIwLjAwIiwiMC4wMCIsIjAuMDAiLCIwLjAwIiwiMC4wMCIsIkxpdnJhaXNvbiBncmF0dWl0ZSBcdTAwZTAgcGFydGlyIGRlIDEwMCBcdTIwYWMiLCJSZXRvdXJlcyBsaWJyZXMiLCIxMTEyOTExLTUwNjQwMDMiLCJWZXN0ZSBoYXJkc2hlbGwgaG9tbWVzIiwiIiwiIiwiZmFsc2UiXQ==';

        $expected_value = [
            'name' => 'Veste hardshell s Karoo Jacket Men M marron',
            'slug' => 'jack-wolfskin-veste-hardshell-hommes-karoo-jacket-men-m-marron-sahara-sand-4060477465760',
            'description' => 'Veste imperméable, respirante avec manches amovibles pour un look 2 en 1.',
            'brand_original' => 'Jack Wolfskin',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'hommes > produits phares > wolfskin tech lab > veste hardshell hommes',
            'color_original' => 'sahara sand',
            'price' => 199.95,
            'old_price' => 399.95,
            'reduction' => 50.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P510FBB56823315S1UA41312d0680V4',
            'image_url' => 'https://www.jack-wolfskin.fr/l/image/product?pid=1112911-5064003&width=1000&format=jpg&index=0',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'M',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_ClassicAllBlacks()
    {
        $headers = 'Reference,Name,Internal reference,Current price,Crossed price,Category,URL,Big image,MPN,Brand,Description,Shipping cost,Ecotaxe,Warranty,Stock,Availability,Performance,Discount,Nouveauté,EAN';

        $payload = 'WyJBRTIwQ0MwNy1OTzktMlhMIiwiQ2hlbWlzZXR0ZSBEb3VibGUgUG9jaGVzIC0gTm9pciIsIjQ1NzI5NjAzNTg1MzgiLCI2OS45MCIsIjQ4LjkwIiwiQ2hlbWlzZXR0ZSIsImh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA1MTA4QkI1NjgyMzMxNVMxVUI0MTJmY2YwMjk5NVY0IiwiaHR0cHM6XC9cL2Nkbi5zaG9waWZ5LmNvbVwvc1wvZmlsZXNcLzFcLzAzMTBcLzI0ODBcLzgwNzRcL3Byb2R1Y3RzXC9jaGVtaXNldHRlLWRvdWJsZS1wb2NoZXMtbm9pci02OTI4MjAuanBnP3Y9MTU5ODM2NTYzMyIsIjM3MDExOTAyOTM1ODIiLCJDbGFzc2ljIEFsbCBCbGFja3MiLCJVbmUgY2hlbWlzZXR0ZSBpZFx1MDBlOWFsZSBwb3VyIGxhIHNhaXNvbiBkZSBsJiMzOTtcdTAwZTl0XHUwMGU5LCBhdmVjIHNvbiBzdHlsZSBiYXJvdWRldXIuIFZvdXMgYWltZXJleiBzZXMgZGV1eCBwb2NoZXMgZmVybVx1MDBlOWVzIHN1ciBsYSBwb2l0cmluZS4gUGV0aXQgZFx1MDBlOXRhaWwgc3VyIGxlcyBtYW5jaGVzIGF2ZWMgdW5lIGZpbmUgYnJvZGVyaWUgYWluc2kgcXUmIzM5O3VuIHBldGl0IGJvdXRvbiBwb3VyIGx1aSBkb25uZXIgZW5jb3JlIHBsdXMgZGUgc3R5bGUuIDEwMCUgQ290b24gMiBQb2NoZXMgZmVybVx1MDBlOWVzIEltcHJlc3Npb25zIERvcyBDb3VwZSBhanVzdFx1MDBlOWUgUGxheWVyIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiIiwiMzcwMTE5MDI5MzU4MiJd';

        $expected_value = [
            'name' => 'Chemisette Double Poches - Noir',
            'slug' => 'chemisette-double-poches-noir-4572960358538',
            'description' => 'Une chemisette idéale pour la saison de l\'été, avec son style baroudeur. Vous aimerez ses deux poches fermées sur la poitrine. Petit détail sur les manches avec une fine broderie ainsi qu\'un petit bouton pour lui donner encore plus de style. 100% Coton 2 Poches fermées Impressions Dos Coupe ajustée Player',
            'brand_original' => 'Classic All Blacks',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'chemisette',
            'color_original' => '',
            'price' => 48.9,
            'old_price' => 69.9,
            'reduction' => 30.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P5108BB56823315S1UB412fcf02995V4',
            'image_url' => 'https://cdn.shopify.com/s/files/1/0310/2480/8074/products/chemisette-double-poches-noir-692820.jpg?v=1598365633',
            'gender' => 'mixte',
            'col' => '',
            'coupe' => 'coupe ajustée',
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

    public function test__parse_row__from_Ilado()
    {
        $headers = 'ID,Name,EAN13,Référence,Price,Promo,Category,URL,image,Description,Devise';

        $payload = 'WyIxODEiLCJHcmktZ3JpIGFscGhhYmV0IGFyZ2VudCBBIiwiMzcwMDk3NDQwMzMyMiIsIjJBTFBIMSIsIjI5IiwiMjkiLCJJTEFETyBQYXJpcyIsImh0dHBzOlwvXC9wYWMuaWxhZG8tcGFyaXMuY29tXC8/UDUxMEIzMTU2ODIzMzE1UzFVQTQxMzAxZjA5MTRWNCIsImh0dHBzOlwvXC93d3cuaWxhZG8tcGFyaXMuY29tXC8yNzU2XC9ncmktZ3JpLWFscGhhYmV0LmpwZyIsIiIsIkVVUiJd';

        $expected_value = [
            'name' => 'Gri-gri alphabet argent A',
            'slug' => 'gri-gri-alphabet-argent-a-181',
            'description' => '',
            'brand_original' => 'Source Name',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'ilado paris',
            'color_original' => '',
            'price' => 29.0,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://pac.ilado-paris.com/?P510B3156823315S1UA41301f0914V4',
            'image_url' => 'https://www.ilado-paris.com/2756/gri-gri-alphabet.jpg',
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

    public function test__parse_row__from_Newchic()
    {
        $headers = 'product_id,id,product_url,name,crossed_price,current_price,category,image,brand,currency,description,availability,condition,shipping_cost';

        $payload = 'WyJTS1VGNzQ2OTEiLCJodHRwczpcL1wvYWN0aW9uLm1ldGFmZmlsaWF0aW9uLmNvbVwvdHJrLnBocD9tY2xpYz1QNEQ3MDE1NjgyMzMxNVMxVUU0MTI0Y2YwOTk0MTc5N1Y0IiwiaHR0cHM6XC9cL3d3dy5uZXdjaGljLmNvbVwvc25lYWtlcnNhbmRhdGhsZXRpYy0zNjIyXC9wLWh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA0RDcwMTU2ODIzMzE1UzFVRTQxMjRjZjA5OTQxNzk3VjQuaHRtbCIsIkNoYXVzc3VyZXMgZGUgc3BvcnQgZFx1MDBlOWNvbnRyYWN0XHUwMGU5ZXMgcG9ydGFibGVzIHJcdTAwZTl0cm8gYW50aWRcdTAwZTlyYXBhbnRlcyBlbiBjdWlyIG1pY3JvZmlicmUgcG91ciBob21tZXMiLCI1MC4zOSBFVVIiLCI1MC4zOSBFVVIiLCJTaG9lcyA+IE1lbidzIFNob2VzID4gU25lYWtlcnMmQXRobGV0aWMiLCJodHRwczpcL1wvaW1nYXoxLmNoaWNjZG4uY29tXC90aHVtYlwvbGFyZ2VcL29hdXBsb2FkXC9uZXdjaGljXC9pbWFnZXNcL0UxXC9EMlwvY2RmYmUxMGYtNmMxYS00YmJiLWI5M2ItZTU4N2Y3NDI1NWU2LmpwZyIsIk5ld2NoaWMiLCJFVVIiLCJDaGF1c3N1cmVzIGRlIHNwb3J0IGRcdTAwZTljb250cmFjdFx1MDBlOWVzIHBvcnRhYmxlcyByXHUwMGU5dHJvIGFudGlkXHUwMGU5cmFwYW50ZXMgZW4gY3VpciBtaWNyb2ZpYnJlIHBvdXIgaG9tbWVzIiwiaW4gc3RvY2siLCJuZXciLCIxMy4yNCBFVVIiXQ==';

        $expected_value = [
            'name' => 'Chaussures de sport décontractées portables rétro antidérapantes en cuir microfibres',
            'slug' => 'chaussures-de-sport-d-contract-es-portables-r-tro-antid-rapantes-en-cuir-microfibre-pour-hommes-https-action-metaffiliation-com-trk-php-mclic-p4d70156823315s1ue4124cf09941797v4',
            'description' => 'Chaussures de sport décontractées portables rétro antidérapantes en cuir microfibre pour hommes',
            'brand_original' => 'Newchic',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'shoes > men\'s shoes > sneakers&athletic',
            'color_original' => '',
            'price' => 50.39,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://www.newchic.com/sneakersandathletic-3622/p-https://action.metaffiliation.com/trk.php?mclic=P4D70156823315S1UE4124cf09941797V4.html',
            'image_url' => 'https://imgaz1.chiccdn.com/thumb/large/oaupload/newchic/images/E1/D2/cdfbe10f-6c1a-4bbb-b93b-e587f74255e6.jpg',
            'gender' => 'homme',
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

    public function test__parse_row__from_LaBoutiqueduHautTalon()
    {
        $headers = 'ID_PRODUCT,ID_PRODUCT_ATTRIBUTE,EAN13,NAME,REF,TTC_AR,TTC_SR,CATEGORIE,URL,REF_FOUR,MARQUE,DESCRIPTION,STOCK,PROMO,ATTRIBUTS,IMAGE_1,IMAGE_2,IMAGE_3,IMAGE_4,IMAGE_5';

        $payload = 'WyIxNTYiLCIyMTI3OCIsIiIsIk11bGVzIG5vaXJlcyB2ZXJuaWVzIC0gUG9pbnR1cmUgOiAzNyIsImxiZGh0LWRvbWluYS0xMDEiLCI2Ni45NSIsIjY2Ljk1IiwiQWNjdWVpbCA+IE11bGUiLCJodHRwczpcL1wvYWN0aW9uLm1ldGFmZmlsaWF0aW9uLmNvbVwvdHJrLnBocD9tY2xpYz1QNTEwM0YzNTY4MjMzMjEyUzFVQTQxMmYyZTAyMzlWNCIsIkRPTTEwMVwvQiIsIkNoYXVzc3VyZXMgZmVtbWVzIERldmlvdXMiLCI8dWw+PGxpPjxzdHJvbmc+TWFycXVlXHUwMGEwOjxcL3N0cm9uZz4gUGxlYXNlcjxcL2xpPjxsaT48c3Ryb25nPlR5cGVcdTAwYTA6IDxcL3N0cm9uZz5NdWxlczxcL2xpPjxsaT48c3Ryb25nPlNhaXNvblx1MDBhMDogPFwvc3Ryb25nPlByaW50ZW1wc1wvRXRcdTAwZTk8XC9saT48bGk+PHN0cm9uZz5IYXV0ZXVyIGR1IHRhbG9uXHUwMGEwOjxcL3N0cm9uZz4gMTUgY208XC9saT48bGk+PHN0cm9uZz5EZXNzdXNcL1RpZ2VcdTAwYTA6PFwvc3Ryb25nPiBTeW50aFx1MDBlOXRpcXVlPFwvbGk+PGxpPjxzdHJvbmc+RG91Ymx1cmVcdTAwYTA6PFwvc3Ryb25nPiBTeW50aFx1MDBlOXRpcXVlPFwvbGk+PGxpPjxzdHJvbmc+Q29sb3Jpc1x1MDBhMDogPFwvc3Ryb25nPk5vaXIgVmVybmlzPFwvbGk+PGxpPjxzdHJvbmc+U2VtZWxsZVx1MDBhMDogPFwvc3Ryb25nPkVsYXN0b21cdTAwZThyZTxcL2xpPjxsaT48c3Ryb25nPkF0dGVudGlvbiA6IFNldWxlcyBsZXMgcGVyc29ubmVzIGV4cFx1MDBlOXJpbWVudFx1MDBlOWVzIHBldXZlbnQgbWFyY2hlciBhdmVjIHVuZSB0ZWxsZSBoYXV0ZXVyIGRlIHRhbG9uLjxcL3N0cm9uZz48XC9saT48XC91bD4iLCIxIiwiMiIsIlBvaW50dXJlPTM3IiwiaHR0cHM6XC9cL3d3dy5sYWJvdXRpcXVlZHVoYXV0dGFsb24uZnJcLzQzNDI4XC9tdWxlcy1ub2lyZXMtdmVybmllcy10cmVzLWhhdXQtdGFsb24tZG9taW5hLTEwMS5qcGciLCJodHRwczpcL1wvd3d3LmxhYm91dGlxdWVkdWhhdXR0YWxvbi5mclwvNTAzMDZcL2NoYXVzc3VyZS1kb21pbmF0cmljZS1tdWxlLW5vaXJlLXZlcm5pZS5qcGciLCJodHRwczpcL1wvd3d3LmxhYm91dGlxdWVkdWhhdXR0YWxvbi5mclwvNTAzMDhcL211bGUtdmVybmllLW5vaXJlLWRvbWluYXRyaWNlLmpwZyIsImh0dHBzOlwvXC93d3cubGFib3V0aXF1ZWR1aGF1dHRhbG9uLmZyXC81MDMwNVwvdGFsb24tZG9taW5hdHJpY2UtbXVsZS1ub2lyZS12ZXJuaWUuanBnIiwiaHR0cHM6XC9cL3d3dy5sYWJvdXRpcXVlZHVoYXV0dGFsb24uZnJcLzUwMzA3XC9tdWxlLXRyYXZlc3Rpcy1ub2lyZS12ZXJuaWUuanBnIl0=';

        $expected_value = [
            'name' => 'Mules noires vernies - Pointure : 37',
            'slug' => 'mules-noires-vernies-pointure-37-156',
            'description' => 'Marque : PleaserType : MulesSaison : Printemps/EtéHauteur du talon : 15 cmDessus/Tige : SynthétiqueDoublure : SynthétiqueColoris : Noir VernisSemelle : ElastomèreAttention : Seules les personnes expérimentées peuvent marcher avec une telle hauteur de talon.',
            'brand_original' => 'Chaussures femmes Devious',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'accueil > mule',
            'color_original' => '',
            'price' => 66.95,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P5103F3568233212S1UA412f2e0239V4',
            'image_url' => 'https://www.laboutiqueduhauttalon.fr/43428/mules-noires-vernies-tres-haut-talon-domina-101.jpg',
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

    public function test__parse_row__from_LolaLiza()
    {
        $headers = 'universal reference,title,id,current price,old price,product category,product link,image link,manufacturer reference,brand,description,shipping costs,ecotaxe,warranty,stock indicator,product availability,performance indicator,discount indicator,novelty indicator,color,size,item group,image link 2';

        $payload = 'WyIzMDAwMDA0MDMwMzIxIiwiUGFudGFsb24gYW1wbGUgXHUwMGUwIGZsZXVycyIsIjEwMDMwMzQiLCIyMy45OSIsIjM5Ljk5IiwiRmVtbWVzID4gUGFudGFsb25zID4gUGFudGFsb25zIGZsdWlkZXMiLCJodHRwczpcL1wvYWN0aW9uLm1ldGFmZmlsaWF0aW9uLmNvbVwvdHJrLnBocD9tY2xpYz1QNEVDMzc1NjgyMzMxNVMxVUM0MTJhZjUwOTA3MTJWNCIsImh0dHBzOlwvXC93d3cubG9sYWxpemEuY29tXC9vblwvZGVtYW5kd2FyZS5zdGF0aWNcLy1cL1NpdGVzLWxvbGFsaXphLWNhdGFsb2dcL2RlZmF1bHRcL2R3ZjRkMTgxYTBcL2ltYWdlc1wvMDY2MDAzOTNfNDMxOF8wMS5qcGciLCJQLUxZU0EiLCJMb2xhTGl6YSIsIkFjaGV0ZXogUGFudGFsb24gYW1wbGUgXHUwMGUwIGZsZXVycyBkZSBsYSBtYXJxdWUgTG9sYUxpemEuIE5vbTogUC1MWVNBIiwiMy45NSIsIiIsIiIsIjAiLCIyIFx1MDBlMCAzIGpvdXJzIG91dnJhYmxlcyIsIiIsIjEiLCIwIiwiTiAtIEtoYWtpIiwiNDQiLCIwNjYwMDM5M180MzE4IiwiaHR0cHM6XC9cL3d3dy5sb2xhbGl6YS5jb21cL29uXC9kZW1hbmR3YXJlLnN0YXRpY1wvLVwvU2l0ZXMtbG9sYWxpemEtY2F0YWxvZ1wvZGVmYXVsdFwvZHc2MjI1ZjU2MlwvaW1hZ2VzXC8wNjYwMDM5M180MzE4XzAyLmpwZyJd';

        $expected_value = [
            'name' => 'Pantalon ample à fleurs',
            'slug' => 'pantalon-ample-fleurs-1003034',
            'description' => 'Achetez Pantalon ample à fleurs de la marque LolaLiza. Nom: P-LYSA',
            'brand_original' => 'LolaLiza',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'femmes > pantalons > pantalons fluides',
            'color_original' => 'n|khaki',
            'price' => 23.99,
            'old_price' => 39.99,
            'reduction' => 40.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4EC3756823315S1UC412af5090712V4',
            'image_url' => 'https://www.lolaliza.com/on/demandware.static/-/Sites-lolaliza-catalog/default/dwf4d181a0/images/06600393_4318_01.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => null,
            'motifs' => 'motif floral',
            'event' => '',
            'style' => null,
            'size' => '44',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload, $headers),
    );
    }

    public function test__parse_row__from_Yoins()
    {
        $payload = 'eyJJRCI6IlNLVTE3MDM5NCIsIm5hbWUiOiJNYW50ZWF1IGxvbmcgZW4gbGFpbmUgXHUwMGUwIGRvdWJsZSBib3V0b25uYWdlIiwiZGVzY3JpcHRpb24iOiJMZSBtYW50ZWF1IGVzdCBwcmluY2lwYWxlbWVudCBmYWJyaXF1XHUwMGU5IFx1MDBlMCBwYXJ0aXIgZGUgcG9seWVzdGVyIGV0IGRlIGNvdG9uLiBJbCBlc3QgZGUgY29uY2VwdGlvbiBcdTAwZTAgZG91YmxlIGJvdXRvbm5hZ2UuIiwicHJvZHVjdFVSTCI6Imh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA0RDZGQjU2ODIzMzE1UzFVQzQxMjRjZDA0ODExM1Y0IiwiaW1hZ2VVUkwiOiJodHRwczpcL1wvaW1hZ2VzLmNoaWNjZG4uY29tXC90aHVtYlwvc291cmNlXC9vYXVwbG9hZFwveW9pbnNcL2ltYWdlc1wvMzNcL0Q5XC82MmQ0YmJjNC05ZDJlLTQ4MTMtYTIzMi0yNTJmYmU3YzBhYzMuanBnIiwicHJpY2UiOiI1NS45NyIsImZyb21QcmljZSI6IjkzLjkxIiwiZGlzY291bnQiOiI0MCUiLCJjYXRlZ29yeVBhdGgiOiIzMjE5PjgxMTI+NDgwNSIsImNhdGVnb3JpZXMiOiJUT1BTIiwic3ViY2F0ZWdvcmllcyI6IkphY2tldHMgJiBDb2F0cyIsInN1YnN1YmNhdGVnb3JpZXMiOiJUcmVuY2ggQ29hdCAiLCJnZW5kZXIiOiJmZW1tZXMiLCJzaXplIjoieHN8c3xtIiwic3RvY2siOiI2Iiwic2l6ZVN0b2NrIjoieHM9NnxzPTR8bT0zIiwic2FsZSI6IlllcyIsImJyYW5kIjoiWW9pbnMiLCJkZWxpdmVyeVRpbWUiOiI3LTIwIGRheXMiLCJkZWxpdmVyeUNvc3RzIjoiMi43MCIsIm1hdGVyaWFsIjoiQXV0cmVcL1BvbHllc3RlciJ9';

        $expected_value = [
            'name' => 'Manteau long en laine à double boutonnage',
            'slug' => 'manteau-long-en-laine-double-boutonnage-sku170394',
            'description' => 'Le manteau est principalement fabriqué à partir de polyester et de coton. Il est de conception à double boutonnage.',
            'brand_original' => 'Yoins',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'tops|jackets & coats|trench coat',
            'color_original' => '',
            'price' => 55.97,
            'old_price' => 93.91,
            'reduction' => 40.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4D6FB56823315S1UC4124cd048113V4',
            'image_url' => 'https://images.chiccdn.com/thumb/source/oaupload/yoins/images/33/D9/62d4bbc4-9d2e-4813-a232-252fbe7c0ac3.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'autre|polyester',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'XS|S|M',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Bazarchic()
    {
        $payload = 'eyJOb20iOiJCYXNrZXRzIFR1YnVsYXIgUnVubmVyIG5vaXJcL2JsZXUiLCJyZWZlcmVuY2VfaW50ZXJuZSI6IjIyNzQxNTUiLCJwcml4X2FjdHVlbCI6IjM1LjAwIiwiY2F0ZWdvcmllIjoiSG9tbWUgPiBDaGF1c3N1cmVzID4gQmFza2V0cyIsIlVSTHByb2R1aXQiOiJodHRwczpcL1wvYWN0aW9uLm1ldGFmZmlsaWF0aW9uLmNvbVwvdHJrLnBocD9tY2xpYz1QNEY0REY1NjgyMzMyNDJTMVVENDEyZjQwMDMxMTAyOFY0IiwiTVBOIjoiTTE5NjQ0XC9DQkxBQ0tcL1NVUlBFVFwvT1dISVRFIiwibWFycXVlIjoiQWRpZGFzIiwiZnJhaXNfZGVfcG9ydCI6IjQuNDkiLCJkZXNjcmlwdGlmIjoiQmFza2V0cyBUdWJ1bGFyIFJ1bm5lciwgTW9kXHUwMGU4bGUgYXZhbnQtZ2FyZGlzdGUgZGFucyBsZXMgYW5uXHUwMGU5ZXMgOTAsIGFkaWRhcyBvZmZyZVx1MDBhMFx1MDBlMCBzYSBUdWJ1bGFyIFJ1bm5lciB1biBsb29rIGVuY29yZSBwbHVzIHRlbmRhbmNlIGVuIGFzc29jaWFudCBkZXMgbWF0aVx1MDBlOHJlcyBtb2Rlcm5lcyBcdTAwZTAgdW4gc3R5bGUgdW4gcGV1IGV4Y2VudHJpcXVlLiBEb3RcdTAwZTllIGQndW5lIHRpZ2UgZW4gblx1MDBlOW9wclx1MDBlOG5lIHJlaGF1c3NcdTAwZTllIGQnZW1waVx1MDBlOGNlbWVudHMgZW4gY3VpciBvZmZyYW50IHVuIGNoYXVzc2FudCBleGNlcHRpb25uZWwsIGVsbGUgZXN0IG11bmllIGQndW5lIHNlbWVsbGUgZXh0XHUwMGU5cmlldXJlIGRvdWJsZSBkZW5zaXRcdTAwZTkgZXQgZCd1biByZW5mb3J0IHNvdWRcdTAwZTkgXHUwMGUwIGwnYXZhbnQtcGllZC4gU29uIGNvbnRyZWZvcnQgZFx1MDBlOWNvdXBcdTAwZTkgYXUgbGFzZXIgYXUgdGFsb24gZXN0IGluc3Bpclx1MDBlOSBkZSBjZWx1aSBkZSBsJ2VtYmxcdTAwZTltYXRpcXVlIGNoYXVzc3VyZSBaWCA3MDAuLCBVbiBjcm9pc2VtZW50IGR1IHNwb3J0LCBzdHJlZXR3ZWFyIGV0IG1vZGUuLCBTYSBzZW1lbGxlIGV4dFx1MDBlOXJpZXVyZSB0dWJ1bGFpcmVcdTAwYTAgZXN0IGluc3Bpclx1MDBlOWUgZGUgY2hhbWJyZXMgXHUwMGUwIGFpciBkZSB2XHUwMGU5bG9zLlx1MDBhMCIsImluZGljYXRldXJfZGVfc3RvY2siOiIxIiwiaW5kaWNhdGV1cl9kZV9wcm9tb3Rpb24iOiI2NSIsIlVSTF9pbWFnZV9wZXRpdGUiOiJodHRwczpcL1wvY2RuLmJhemFyY2hpYy5jb21cL2lcL3RtcFwvNzAwMjYyNi5qcGciLCJVUkxfaW1hZ2VfbW95ZW5uZSI6Imh0dHBzOlwvXC9jZG4uYmF6YXJjaGljLmNvbVwvaVwvdG1wXC83MDAyNjI2LmpwZyIsIlVSTF9pbWFnZV9ncmFuZGUiOiJodHRwczpcL1wvY2RuLmJhemFyY2hpYy5jb21cL2lcL3RtcFwvNzAwMjYyNi5qcGciLCJwcml4X2JhcnJlIjoiMTAwLjAwIiwiZ2VucmUiOiJIb21tZSIsIkNhdGVnb3JpZV9maW5hbGUiOiJCYXNrZXRzIiwiRGVidXRfZGVfUmVtaXNlIjoiMjAyMC0xMi0wOCIsIkZpbl9kZV9yZW1pc2UiOiIyMDIxLTAxLTAxIiwiVGFpbGxlIjoiVC40MSAxXC8zIiwiRmFtaWxsZV9kZV9wcm9kdWl0IjoiMjI3NDE1NSIsIkNvdWxldXIiOiJOb2lyQmxldSIsIkRcdTAwZTlsYWlfZGVfbGl2cmFpc29uIjoiNCIsIk1hdGlcdTAwZThyZSI6IlNlbWVsbGUgZXh0XHUwMGU5cmlldXJlIDogQXV0cmVzIG1hdFx1MDBlOXJpYXV4In0=';

        $expected_value = [
            'name' => 'Baskets Tubular Runner noir/bleu',
            'slug' => 'baskets-tubular-runner-noir-bleu-2274155',
            'description' => 'Baskets Tubular Runner, Modèle avant-gardiste dans les années 90, adidas offre à sa Tubular Runner un look encore plus tendance en associant des matières modernes à un style un peu excentrique. Dotée d\'une tige en néoprène rehaussée d\'empiècements en cuir offrant un chaussant exceptionnel, elle est munie d\'une semelle extérieure double densité et d\'un renfort soudé à l\'avant-pied. Son contrefort découpé au laser au talon est inspiré de celui de l\'emblématique chaussure ZX 700., Un croisement du sport, streetwear et mode., Sa semelle extérieure tubulaire  est inspirée de chambres à air de vélos. ',
            'brand_original' => 'Adidas',
            'merchant_original' => 'Source Name',
            'currency_original' => 'EUR',
            'category_original' => 'homme > chaussures > baskets|baskets',
            'color_original' => 'noirbleu',
            'price' => 35.0,
            'old_price' => 100.0,
            'reduction' => 65.0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4F4DF568233242S1UD412f400311028V4',
            'image_url' => 'https://cdn.bazarchic.com/i/tmp/7002626.jpg',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'autres materiaux',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'T.41 1|3',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Desigual()
    {
        $payload = 'eyJuYW1lIjoiUGFudGFsb24gamVhbiBzbGltIC0gQkxVRSAtIDM0IiwicHJvZHVjdFVybCI6Imh0dHBzOlwvXC9hY3Rpb24ubWV0YWZmaWxpYXRpb24uY29tXC90cmsucGhwP21jbGljPVA0RUZBQjU2ODIzMzE3UzFVRDQxMmI1ZDAxNTk4NzhWNCIsImltYWdlVXJsIjoiaHR0cHM6XC9cL3d3dy5kZXNpZ3VhbC5jb21cL2R3XC9pbWFnZVwvdjJcL0JDVlZfUFJEXC9vblwvZGVtYW5kd2FyZS5zdGF0aWNcLy1cL1NpdGVzLWRlc2lndWFsLW0tY2F0YWxvZ1wvZGVmYXVsdFwvaW1hZ2VzXC9CMkNcLzIwV1dQTjM1XzUxNjJfMS5qcGciLCJkZXNjcmlwdGlvbiI6IiBFbnZpZSBkJ3VuIHBhbnRhbG9uIHNsaW0gY2hldmlsbGVzIGRpZmZcdTAwZTlyZW50IGRlcyBhdXRyZXMgPyBNaXNleiBzdXIgZGVzIGRcdTAwZTl0YWlscyB0ZWxzIHF1ZSBjZXV4IGRlIGNlIHBhbnRhbG9uIGVuIGplYW4gcXVpIGVzdCBub24gc2V1bGVtZW50IGZhaXQgZCd1biB0aXNzdSBvcmdhbmlxdWUgZFx1MDBlOWxhdlx1MDBlOSwgbWFpcyBpbmNsdXQgYXVzc2kgdHJvaXMgcG9jaGVzIGF2YW50IHN1cHBsXHUwMGU5bWVudGFpcmVzIFx1MDBlMCBmZXJtZXR1cmUgXHUwMGM5Y2xhaXIgZXQgdW5lIGNlaW50dXJlIFx1MDBlMCBmZXJtZXR1cmUgcGFyIGRvdWJsZSBhbm5lYXUgbVx1MDBlOXRhbGxpcXVlLiAgIEZlcm1ldHVyZSBcdTAwYzljbGFpciBldCBib3V0b24gICBTZXB0IHBvY2hlcyAgVGFpbGxlIG1veWVubmUgIEluY2x1dCB0cm9pcyBwb2NoZXMgYXZhbnQgc3VwcGxcdTAwZTltZW50YWlyZXMgXHUwMGUwIGZlcm1ldHVyZSBcdTAwYzljbGFpciAgQ2VpbnR1cmUgXHUwMGUwIGRvdWJsZSBhbm5lYXUgbVx1MDBlOXRhbGxpcXVlIGRlIGZlcm1ldHVyZSAgU2xpbSBmaXQgIENoZXZpbGxlcyAgUGlcdTAwZThjZSBvcmdhbmlxdWUgIE0yMFdXUE4zNS01MTYyICAiLCJwcmljZSI6Ijk5Ljk1IiwiY3VycmVuY3kiOiJFVVIiLCJURFByb2R1Y3RJZCI6IjM0NDg3MjgyNDEiLCJURENhdGVnb3J5SUQiOiI2OCIsIlREQ2F0ZWdvcnlOYW1lIjoiTW9kYSIsIm1lcmNoYW50Q2F0ZWdvcnlOYW1lIjoiTW9kYSIsImF2YWlsYWJpbGl0eSI6ImluIHN0b2NrIiwiYnJhbmQiOiJEZXNpZ3VhbCIsImNvbmRpdGlvbiI6Im5ldyIsInByb2dyYW1OYW1lIjoiREVTSUdVQUwgRlIiLCJwcm9ncmFtSWQiOiIyODY3MzciLCJhZHZlcnRpc2VyUHJvZHVjdFVybCI6Imh0dHBzOlwvXC93d3cuZGVzaWd1YWwuY29tXC9mcl9GUlwvMjBXV1BOMzU1MTYyMzQuaHRtbCIsImZpZWxkcyI6eyJDYXRlZ29yaWEiOiJGZW1tZSA+IFZcdTAwZWF0ZW1lbnRzID4gUGFudGFsb25zIiwiZ19hZGRpdGlvbmFsX2ltYWdlX2xpbmsiOiJodHRwczpcL1wvd3d3LmRlc2lndWFsLmNvbVwvZHdcL2ltYWdlXC92MlwvQkNWVl9QUkRcL29uXC9kZW1hbmR3YXJlLnN0YXRpY1wvLVwvU2l0ZXMtZGVzaWd1YWwtbS1jYXRhbG9nXC9kZWZhdWx0XC9pbWFnZXNcL0IyQ1wvMjBXV1BOMzVfNTE2Ml8yLmpwZyIsImdfYWdlX2dyb3VwIjoiYWR1bHQiLCJnX2NvbG9yIjoiQkxVRSIsImdfZ2VuZGVyIjoiZmVtYWxlIiwiZ19pdGVtX2dyb3VwX2lkIjoiMjBXV1BOMzUiLCJnX21hdGVyaWFsIjoiRUxBU1RBTkUsIFZJU0NPU0UsIE1PREFMLCBQT0xZRVNURVIsIENPVFRPTiIsImdfbXBuIjoiMjBXV1BOMzU1MTYyMzQiLCJnX3NpemUiOiIzNCIsIlByb2R1Y3RvSUQiOiIyMFdXUE4zNTUxNjIzNCJ9fQ==';

        $expected_value = [
            'name' => 'Pantalon jean slim - BLUE - 34',
            'slug' => 'pantalon-jean-slim-blue-34-20wwpn35516234',
            'description' => 'Envie d\'un pantalon slim chevilles différent des autres ? Misez sur des détails tels que ceux de ce pantalon en jean qui est non seulement fait d\'un tissu organique délavé, mais inclut aussi trois poches avant supplémentaires à fermeture Éclair et une ceinture à fermeture par double anneau métallique.   Fermeture Éclair et bouton   Sept poches  Taille moyenne  Inclut trois poches avant supplémentaires à fermeture Éclair  Ceinture à double anneau métallique de fermeture  Slim fit  Chevilles  Pièce organique  M20WWPN35-5162',
            'brand_original' => 'Desigual',
            'merchant_original' => 'DESIGUAL',
            'currency_original' => 'EUR',
            'category_original' => 'femme > vêtements > pantalons',
            'color_original' => 'blue',
            'price' => 99.95,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://action.metaffiliation.com/trk.php?mclic=P4EFAB56823317S1UD412b5d0159878V4',
            'image_url' => 'https://www.desigual.com/dw/image/v2/BCVV_PRD/on/demandware.static/-/Sites-desigual-m-catalog/default/images/B2C/20WWPN35_5162_1.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'elastane|viscose|modal|polyester|cotton',
            'model' => null,
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => '34',
            'livraison' => '',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
