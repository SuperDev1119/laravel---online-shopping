<?php

namespace Tests\Models\Parsers;

use App\Models\Parsers\Daisycon;

class DaisyconTest extends \Tests\Models\SourceTest
{
    public static $klass = Daisycon::class;

    public static $headers = 'id,name,currency,product_count,last_modified,daisycon_unique_id_since,daisycon_unique_id_modified,daisycon_unique_id,previous_daisycon_unique_id,data_hash,status,insert_date,update_date,delete_date,additional_costs,brand_logo,category,category_path,condition,description,description_short,sku,in_stock,in_stock_amount,keywords,link,price,price_old,priority,terms_conditions,title,price_shipping,delivery_time,delivery_description,size,size_description,material_description,model,gender_target,brand,ean,color_primary,google_category_id,image_small,image_medium,image_large';

    public function test__parse_row__from_Kings_of_Indigo_femme()
    {
        // given
        $payload = 'WyIxNDIwOCIsIktpbmdzIG9mIEluZGlnbyAoSU5UKSIsIkVVUiIsIjMyNzciLCIyMDIwLTA2LTA4IDAxOjI0OjEzIiwiMjAxOS0wNi0xMyAxMzoyODoxNSIsInRydWUiLCJkZTI2MGVhMzFkNjZjNDlhYjEwZDAzODFjZmE0NzVmMyIsIiIsIjAwMDZmOWQxYzI2MDhjOGQwOTA5YjNiMTczMDczM2FhIiwiYWN0aXZlIiwiMjAyMC0wMy0zMSAxMTowMzozOCIsIjIwMjAtMDUtMDggMDE6NDA6MjkiLCIiLCIiLCJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDA2MFwvNDU1M1wvMjI3NVwvZmlsZXNcL0xvZ29fbmV3X2tpbmdzXzMwMHgucG5nIiwiVnJvdXdlbnxLbGVkaW5nfEp1bXBzdWl0IiwiSnVtcHN1aXQiLCJuZXciLCJBc2FrYSBpcyBhIGR1bmdhcmVlIG1hZGUgaW4gYW4gb3BlbiB3ZWF2ZSBkZW5pbS48YnJcLz5UaGUgbGVncyBhcmUgd2lkZSBhbmQgZmxhcmVkLjxiclwvPkl0IGhhcyBhIHJhdyBlZGdlIGZyaW5nZSBmaW5pc2guPGJyXC8+UmV2ZXJzZSBmYWJyaWMgZGV0YWlscyBvbiB0aGUgcG9ja2V0cyB0byBnaXZlIGEgdmludGFnZSBsb29rIHRvIHRoZSBnYXJtZW50LjxiclwvPlZlZ2FuIGJyYW5kIHBhdGNoIGF0IHRoZSBiYWNrLjxiclwvPjxiclwvPlRoaXMgZ2FybWVudCBpcyBtYWRlIHdpdGggb3JnYW5pYyBjb3R0b24sIGEgbmF0dXJhbCBmaWJlciB3aXRoIG5vIGNoZW1pY2FsIHRyZWF0bWVudCBtYWtpbmcgaXQgc2FmZXIgZm9yIHRoZSBwbGFuZXQsIGZhcm1lciBhbmQgd2VhcmVyLiBUaGlzIGdhcm1lbnQgaXMgYWxzbyBtYWRlIHdpdGggbGluZW4sIGEgZHVyYWJsZSBmaWJlciB3aXRoIG5vIGNoZW1pY2FsIHRyZWF0bWVudC4gVGhlIHByb2R1Y3Rpb24gcHJvY2VzcyBmcm9tIHBsYW50IHRvIGZpYmVyIHJlcXVpcmVzIGxlc3Mgd2F0ZXIgdGhhbiBjb3R0b24gYW5kIGxpbmVuIGlzIDEwMCUgYmlvZGVncmFkYWJsZS4iLCJBU0FLQSBKdW1wc3VpdCIsIjMxMzQyNDE2ODIyMzg3IiwiMSIsIjEwIiwiSzIwMDEwMDAwNSIsImh0dHBzOlwvXC9uZHQ1Lm5ldFwvY1wvP3NpPTE0MjA4JmxpPTE2MTUwNzEmd2k9MzQ4NTM4JnBpZD1kZTI2MGVhMzFkNjZjNDlhYjEwZDAzODFjZmE0NzVmMyZkbD1wcm9kdWN0cyUyRmFzYWthLW1pZC1ibHVlLWZyaW5nZSUzRmNoYW5uYWJsZSUzRGU3ODkxMi5NekV6TkRJME1UWTRNakl6T0RjJndzPSIsIjE5OS45OSIsIjE5OS45OSIsIjEiLCIiLCJBU0FLQSIsIjAiLCIxIiwiUG9zdE5MIFBha2tldFBvc3QiLCJNIiwiIiwiNjAlIE9yZ2FuaWMgY290dG9uLCA0MCUgbGluZW4iLCI4NzE5MTc1MjM2OTMxIiwiZmVtYWxlIiwiS2luZ3Mgb2YgaW5kaWdvIiwiODcxOTE3NTIzNjkzMSIsIk1pZCBCbHVlIEZyaW5nZSIsIjUyNTAiLCJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDA2MFwvNDU1M1wvMjI3NVwvcHJvZHVjdHNcL0syMDAxMDAwMDVfMzAzOV80LmpwZz92PTE1ODg2OTUzMzciLCIiLCJodHRwczpcL1wvY2RuLnNob3BpZnkuY29tXC9zXC9maWxlc1wvMVwvMDA2MFwvNDU1M1wvMjI3NVwvcHJvZHVjdHNcL0syMDAxMDAwMDVfMzAzOV8xLmpwZz92PTE1ODg2OTUzMzciXQ==';

        // when
        $expected_value = [
            'name' => 'ASAKA',
            'slug' => 'asaka-de260ea31d66c49ab10d0381cfa475f3',
            'description' => 'Asaka is a dungaree made in an open weave denim.The legs are wide and flared.It has a raw edge fringe finish.Reverse fabric details on the pockets to give a vintage look to the garment.Vegan brand patch at the back.This garment is made with organic cotton, a natural fiber with no chemical treatment making it safer for the planet, farmer and wearer. This garment is also made with linen, a durable fiber with no chemical treatment. The production process from plant to fiber requires less water than cotton and linen is 100% biodegradable.',
            'brand_original' => 'Kings of indigo',
            'merchant_original' => 'Kings of Indigo',
            'currency_original' => 'EUR',
            'category_original' => 'jumpsuit',
            'color_original' => 'mid blue fringe',
            'price' => 199.99,
            'old_price' => 0,
            'reduction' => 0,
            'url' => 'https://ndt5.net/c/?si=14208&li=1615071&wi=348538&pid=de260ea31d66c49ab10d0381cfa475f3&dl=products%2Fasaka-mid-blue-fringe%3Fchannable%3De78912.MzEzNDI0MTY4MjIzODc&ws=',
            'image_url' => 'https://cdn.shopify.com/s/files/1/0060/4553/2275/products/K200100005_3039_1.jpg?v=1588695337',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => 'organic cotton|linen',
            'model' => '8719175236931',
            'motifs' => '',
            'event' => '',
            'style' => null,
            'size' => 'M',
            'livraison' => '1 day',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Cupshe_femme_discount()
    {
        // given
        $payload = 'WyIxNDQzMSIsIkN1cHNoZSAoRlIpIiwiRVVSIiwiNjA4NiIsIjIwMjAtMDYtMDggMDI6MjQ6NTEiLCIyMDE5LTA4LTIyIDEwOjQzOjAyIiwidHJ1ZSIsImQ5YTgzNGM1ZDYzZmE0ODQ1MWRlMGM4MzcxNDYzMDIwIiwiIiwiMDA3NzA1ZDllMzQ3ODBlY2EyODU2MmI4Y2MyOTI0M2QiLCJhY3RpdmUiLCIyMDE5LTA5LTEwIDE0OjUxOjU0IiwiMjAyMC0wMS0xNyAxNzozNToxNCIsIiIsIiIsIiIsIkJpa2luaSIsIlZcdTAwZWF0ZW1lbnRzIGV0IGFjY2Vzc29pcmVzfFZcdTAwZWF0ZW1lbnRzfFZcdTAwZWF0ZW1lbnRzIGRlIGJhaW4iLCJOb3V2ZWxsZSIsIk5vdHJlIEJpa2luaSBGbG9yYWwgU3VubnkgQmF5IHZvdXMgZmVyYSBzb3VyaXJlIHBlbmRhbnQgZGVzIGpvdXJzISBMZSBoYXV0IHByXHUwMGU5c2VudGUgZGVzIGJyZXRlbGxlcyBjcm9pc1x1MDBlOWVzIGF1IG5pdmVhdSBkZSBsYSBwb2l0cmluZS4gQnJldGVsbGVzIHJcdTAwZTlnbGFibGVzIHBvdXIgdW4gYWp1c3RlbWVudCBwYXJmYWl0LiBMZSBtYWduaWZpcXVlIGRcdTAwZTl0YWlsIFx1MDBlMCBpbXByaW1cdTAwZTkgZmxvcmFsIGNvbmZcdTAwZThyZSB1biBkZXNpZ24gdW5pcXVlIGV0IHRlbmRhbmNlLiIsIiIsIkFCMjA1MTVNTSIsIjEiLCIiLCIiLCJodHRwczpcL1wvbmR0NS5uZXRcL2NcLz9zaT0xNDQzMSZsaT0xNjIxOTExJndpPTM0ODUzOCZwaWQ9ZDlhODM0YzVkNjNmYTQ4NDUxZGUwYzgzNzE0NjMwMjAmZGw9Y29sbGVjdGlvbnMlMkZiaWtpbmktc2V0cyUyRnByb2R1Y3RzJTJGYmFpZS1lbnNvbGVpbGxlZS1iaWtpbmktZmxvcmFsJTNGdmFyaWFudCUzRDIyOTcwNjgwODAzMzkyJndzPSIsIjIwLjkiLCIyOC45OSIsIiIsIiIsIkJhaWUgRW5zb2xlaWxsXHUwMGU5ZSBCaWtpbmkgRmxvcmFsIiwiMCIsIjYiLCIiLCJNIiwiIiwiIiwiIiwiZmVtYWxlIiwiQ1VQU0hFIiwiIiwiSmF1bmVcL0JsYW5jIiwiMjExIiwiIiwiIiwiaHR0cDpcL1wvc3RhdGljLmN1cHNoZS5jb21cL2ltYWdlc1wvQUIyMDUxNU0uanBnIl0=';

        // when
        $expected_value = [
            'name' => 'Baie Ensoleillée Bikini Floral',
            'slug' => 'baie-ensoleill-e-bikini-floral-d9a834c5d63fa48451de0c8371463020',
            'description' => 'Notre Bikini Floral Sunny Bay vous fera sourire pendant des jours! Le haut présente des bretelles croisées au niveau de la poitrine. Bretelles réglables pour un ajustement parfait. Le magnifique détail à imprimé floral confère un design unique et tendance.',
            'brand_original' => 'CUPSHE',
            'merchant_original' => 'Cupshe',
            'currency_original' => 'EUR',
            'category_original' => 'vêtements et accessoires|vêtements|vêtements de bain',
            'color_original' => 'jaune|blanc',
            'price' => 20.9,
            'old_price' => 28.99,
            'reduction' => 28,
            'url' => 'https://ndt5.net/c/?si=14431&li=1621911&wi=348538&pid=d9a834c5d63fa48451de0c8371463020&dl=collections%2Fbikini-sets%2Fproducts%2Fbaie-ensoleillee-bikini-floral%3Fvariant%3D22970680803392&ws=',
            'image_url' => 'http://static.cupshe.com/images/AB20515M.jpg',
            'gender' => 'femme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => 'AB20515MM',
            'motifs' => 'motif floral',
            'event' => '',
            'style' => null,
            'size' => 'M',
            'livraison' => '6 days',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }

    public function test__parse_row__from_Sacha_homme_discount()
    {
        // given
        $payload = 'WyIxMzMxMSIsIlNhY2hhIChGUikiLCJFVVIiLCI3MTI0IiwiMjAyMC0wNi0wOCAxMDoxODo0NiIsIjIwMTktMDMtMjEgMTE6NTU6NDMiLCJ0cnVlIiwiYmI4ZTM1NmUxZTk0YWY4NjFlNDFhNTEzZmRmMmM1YjUiLCIiLCIwMDI3MjdlYzY4MzM3NmQ5MTVhNGM3NTQ3NDM0NjkxYSIsImFjdGl2ZSIsIjIwMjAtMDEtMTQgMDk6Mzg6MzIiLCIyMDIwLTA2LTA4IDAzOjI0OjAzIiwiIiwiIiwiU2FjaGEiLCJNb2RlIiwiIiwibmV3IiwiQ2VzIGNoYXVzc3VyZXNcdTAwZTAgbGFjZXRzIGJsZXVlcyBicmFuY2hcdTAwZTllcyBmb250IHBhcnRpZSBkZSBsYSBjb2xsZWN0aW9uIFNhY2hhIENhc3VhbC4gTGUgY1x1MDBmNHRcdTAwZTkgZXQgbGUgZGV2YW50IGRlIGxhIGNoYXVzc3VyZSBzb250IGRvdFx1MDBlOXMgZGUgZmxldXJzIGJyb2RcdTAwZTllcywgY2UgcXVpIGVzdCB1biBkXHUwMGU5dGFpbCBzeW1wYS4gQ2VsYSBhcHBvcnRlIHVuZSB0b3VjaGUgZGUgZmFudGFpc2llIFx1MDBlMCBjZXMgY2hhdXNzdXJlcyBcdTAwZTAgbGFjZXRzIGNsYXNzaXF1ZXMuIEwnZXh0XHUwMGU5cmlldXIgZGUgbGEgY2hhdXNzdXJlIGVzdCBlbiBjdWlyIGV0IGxhIGRvdWJsdXJlIGVzdCBlbiB0ZXh0aWxlLiBQb3VyIHVuZSB0ZW51ZSBkXHUwMGU5Y29udHJhY3RcdTAwZTllLCBhc3NvcnRpc3NleiBsZXMgY2hhdXNzdXJlcyBhdmVjIHVuIGJlYXUgamVhbiBldCB1biBzd2VhdGVyLiBPdSBcdTAwZTlnYXlleiB2b3RyZSBsb29rIHByb2Zlc3Npb25uZWwgZW4gcG9ydGFudCBsZXMgY2hhdXNzdXJlcyBhdmVjIHVuIHBhbnRhbG9uLiIsIiIsIkZSXzQuNzg2OC00MiIsIjEiLCIiLCIiLCJodHRwczpcL1wvbHQ0NS5uZXRcL2NcLz9zaT0xMzMxMSZsaT0xNTkxMTY5JndpPTM0ODUzOCZwaWQ9YmI4ZTM1NmUxZTk0YWY4NjFlNDFhNTEzZmRmMmM1YjUmZGw9aG9tbWVzJTJGY2hhdXNzdXJlcy1hLWxhY2V0cy1lbi1jdWlyLWF2ZWMtYnJvZGVyaWVzLWJsZXUtNHg3ODY4Lmh0bWwlM0ZjaGFubmFibGUlM0RlNTg2ODcuTmprNVN6STJOVEEwSUVKc2RXVSUyNnV0bV9jYW1wYWlnbiUzRERlcmJpZXMlMkIlMjVDMyUyNUEwJTJCbGFjZXRzJTI2dXRtX2NvbnRlbnQlM0Q0Ljc4NjglMjZ1dG1fc291cmNlJTNEZGFpc3ljb24lMjZ1dG1fbWVkaXVtJTNEYWZmaWxpYXRlJTI2dXRtX3Rlcm0lM0Qmd3M9IiwiODQuOTkiLCI5OS45OSIsIiIsIiIsIkNoYXVzc3VyZXNcdTAwZTAgbGFjZXRzIGVuIGN1aXIgYXZlYyBicm9kZXJpZXMgLSBibGV1IChNYWF0IDQyKSIsIiIsIjEiLCIiLCI0MiIsIiIsIiIsIiIsIm1hbGUiLCJTYWNoYSIsIjIzMDAwMTMwODgwMzIiLCJibGF1dyIsIiIsIiIsIiIsImh0dHBzOlwvXC9zYWNoYS54Y2RuLm5sXC9STTEyMDAsMTIwMFwvLVwvNC43ODY4XzEuanBnIl0=';

        // when
        $expected_value = [
            'name' => 'Chaussuresà lacets en cuir avec broderies - bleu',
            'slug' => 'chaussures-lacets-en-cuir-avec-broderies-bleu-bb8e356e1e94af861e41a513fdf2c5b5',
            'description' => 'Ces chaussuresà lacets bleues branchées font partie de la collection Sacha Casual. Le côté et le devant de la chaussure sont dotés de fleurs brodées, ce qui est un détail sympa. Cela apporte une touche de fantaisie à ces chaussures à lacets classiques. L\'extérieur de la chaussure est en cuir et la doublure est en textile. Pour une tenue décontractée, assortissez les chaussures avec un beau jean et un sweater. Ou égayez votre look professionnel en portant les chaussures avec un pantalon.',
            'brand_original' => 'Sacha',
            'merchant_original' => 'Sacha',
            'currency_original' => 'EUR',
            'category_original' => 'mode',
            'color_original' => 'blauw',
            'price' => 84.99,
            'old_price' => 99.99,
            'reduction' => 15,
            'url' => 'https://lt45.net/c/?si=13311&li=1591169&wi=348538&pid=bb8e356e1e94af861e41a513fdf2c5b5&dl=hommes%2Fchaussures-a-lacets-en-cuir-avec-broderies-bleu-4x7868.html%3Fchannable%3De58687.Njk5SzI2NTA0IEJsdWU%26utm_campaign%3DDerbies%2B%25C3%25A0%2Blacets%26utm_content%3D4.7868%26utm_source%3Ddaisycon%26utm_medium%3Daffiliate%26utm_term%3D&ws=',
            'image_url' => 'https://sacha.xcdn.nl/RM1200,1200/-/4.7868_1.jpg',
            'gender' => 'homme',
            'col' => '',
            'coupe' => '',
            'manches' => '',
            'material' => '',
            'model' => 'FR_4.7868-42',
            'motifs' => 'motif floral',
            'event' => '',
            'style' => null,
            'size' => '42',
            'livraison' => '1 day',
        ];

        // then
        $this->assertEquals(
      $expected_value,
      $this->parse_payload($payload),
    );
    }
}
