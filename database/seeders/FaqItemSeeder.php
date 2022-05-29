<?php

namespace Database\Seeders;

use App\Models\FaqItem;
use Illuminate\Database\Seeder;

class FaqItemSeeder extends Seeder
{
    public function run()
    {
        foreach ([
            _i('%s : Qu’est-ce que c’est ?', [config('app.site_name')]) => _i('%s est un moteur de recherche shopping dédié à la mode. Nous travaillons aujourd’hui avec les plus grands marchands Européen tel que Sarenza, Galeries Lafayette ou La Redoute. L’objectif est vous proposer l’offre la plus large du web.', [config('app.site_name')]),
            _i('Comment ça marche ?') => _i('Recherchez : une référence parmi 1,6 million de produits, 10 000 marques et 150 marchands. Comparez : en utilisant 4 000 critères de recherche (catégories, coupes, styles, couleurs, évènements...), ou via une barre de recherche ultra performante. Achetez : directement chez l\'un de nos 150 partenaires sélectionnés pour leur sérieux et leurs qualités.'),
            _i('Qui gère la livraison, les échanges et les retours ?') => _i('Nous vous proposons les produits de boutiques partenaires. Vous serez donc redirigé et vous réglerez vos achats directement sur le site de la boutique partenaire. Les prix affichés sur notre site sont les mêmes que sur les sites partenaires. Il n’y a aucun surcoût lorsque vous utilisez notre plate-forme. Le prix total de votre commande est indiqué lors de la finalisation de votre achat sur le site de la boutique partenaire.'),
            _i('Pourquoi des prix différents pour un même article ?') => _i('Nous vous proposons les produits de boutiques partenaires sélectionnées. Ainsi vous serez redirigé et vous réglerez vos achats directement sur le site de la boutique partenaire. Le prix total de votre commande est indiqué lors de la finalisation de votre achat sur le site de la boutique partenaire.'),
            _i('Puis-je acheter des produits directement sur le site %s ?', [config('app.site_name')]) => _i('Non. Nous sommes une plate-forme indépendante et nous travaillons avec des boutiques partenaires sous le principe de l’affiliation. %s n’est pas une boutique en ligne : nous ne vendons aucun produit.', [config('app.site_name')]),
            _i('Que faire en cas de problème avec ma commande?') => _i('Il faut prendre contact avec la boutique avec laquelle vous avez commandé. %s n’est pas une boutique en ligne et n’a donc pas accès au détail de votre commande. Nous sélectionnons rigoureusement nos partenaires commerciaux, à ce titre, si jamais vous rencontrez des difficultés avec l’un de nos partenaires, merci de nous tenir informé par E-Mail à l’adresse suivante : ', [config('app.site_name')]).'<a href="mailto:'.config('app.email').'">'.config('app.email').'</a>',
            _i('Nous n\'avons toujours pas répondu à vos questions ?') => _i('Contactez-nous à l’adresse suivante : ').'<a href="mailto:'.config('app.email').'">'.config('app.email').'</a>',
        ] as $q => $a) {
            FaqItem::updateOrCreate([
                'question' => '⭐️ '.$q,
                'answer' => $a,
            ]);
        }
    }
}
