<?php

namespace Database\Seeders;

use App\Models\PushGrid;
use Illuminate\Database\Seeder;

class PushGridSeeder extends Seeder
{
    public function run()
    {
        foreach ([
            'https://media.giphy.com/media/MEgGD8bV72hfq/source.gif',
            'https://media.giphy.com/media/hnl83xVQxpqJG/source.gif',
            'https://media.giphy.com/media/26gJyphdSEVnmUes0/source.gif',
            'https://media.giphy.com/media/twKoUll2ht6OA/source.gif',
            'https://media.giphy.com/media/83d5GUzJy25FdPnfJ7/source.gif',
            'https://media.giphy.com/media/1jY7CpwS16K2qyJgrY/giphy.gif',
            'https://media.giphy.com/media/5TV0ByBKtP7pu/source.gif',
            'https://media.giphy.com/media/KWpbkiIezGheU/giphy.gif',
            'https://media.giphy.com/media/dBIXZZwg7m8iiPxOQc/giphy.gif',
            'https://media.giphy.com/media/Hm1vMiYhIedaM/source.gif',
            'https://media.giphy.com/media/nADclROyPirtK/source.gif',
            'https://media.giphy.com/media/9JJPXlZizyWHe/source.gif',
            'https://media.giphy.com/media/pZIjL43gnO7du/source.gif',
            'https://media.giphy.com/media/l0NwC1gJIigcRXpaU/source.gif',
            'https://media.giphy.com/media/q3l2BMj5bzMTS/source.gif',
            'https://media.giphy.com/media/RLJk7R3mvmawWdjmCq/giphy.gif',
            'https://media.giphy.com/media/xU1GNfQqMjquoW0pYE/source.gif',
            'https://media.giphy.com/media/AG43tw8upJRNUOcFPO/source.gif',
            'https://media.giphy.com/media/d3mmQ3z2W64yjgC4/giphy.gif',
            'https://media.giphy.com/media/ZdJSjTK5UWACI/source.gif',
            'https://media.giphy.com/media/Fmqe0ZYC93uhO/source.gif',
            'https://media.giphy.com/media/pVLPTrNfTfbtOhVLQr/giphy.gif',
            'https://media.giphy.com/media/dVzP74VkhiHTSZs1QE/source.gif',
            'https://media.giphy.com/media/9w475hDWEPVlu/source.gif',
        ] as $url) {
            PushGrid::updateOrCreate([
                'url' => $url,
            ])->save();
        }
    }
}
