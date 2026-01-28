<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['category' => 'Lunch', 'name' => 'Gegrilde Kipsandwich', 'description' => 'Sappige gegrilde kipfilet met sla, tomaat en mayo', 'price' => 8.50],
            ['category' => 'Lunch', 'name' => 'Classic Caesar Salad', 'description' => 'Krokante romaine sla, croutons en Caesar dressing', 'price' => 7.00],
            ['category' => 'Lunch', 'name' => 'Veggie Wrap', 'description' => 'Gemengde groenten met hummus in een volkoren wrap', 'price' => 6.50],
            ['category' => 'Lunch', 'name' => 'Beef Burger', 'description' => 'Huisgemaakte rundvleesburger met cheddar kaas en augurken', 'price' => 8.00],
            ['category' => 'Lunch', 'name' => 'Tonijnsalade', 'description' => 'Verse tonijn met gemengde sla en balsamico dressing', 'price' => 8.00],
            ['category' => 'Lunch', 'name' => 'Caprese Panini', 'description' => 'Tomaat, mozzarella en basilicum op geroosterd broodje', 'price' => 7.50],
            ['category' => 'Lunch', 'name' => 'Clubsandwich', 'description' => 'Drie lagen brood met kip, bacon, sla en tomaat', 'price' => 8.50],
            ['category' => 'Lunch', 'name' => 'Quinoasalade', 'description' => 'Quinoa met gegrilde groenten en feta', 'price' => 7.50],
            ['category' => 'Lunch', 'name' => 'Spinazie en Feta Quiche', 'description' => 'Quiche met spinazie, feta en een korst van bladerdeeg', 'price' => 7.00],
            ['category' => 'Lunch', 'name' => 'Avocado Toast', 'description' => 'Geroosterd brood met avocado, tomaat en een scheutje olijfolie', 'price' => 6.00],

            ['category' => 'Diner', 'name' => 'Steak Frites', 'description' => 'Gegrilde steak geserveerd met frietjes', 'price' => 14.00],
            ['category' => 'Diner', 'name' => 'Spaghetti Carbonara', 'description' => 'Romige pasta met spek en parmezaanse kaas', 'price' => 12.50],
            ['category' => 'Diner', 'name' => 'Geschroeide Zalm', 'description' => 'Zalmfilet met citroenboter saus en asperges', 'price' => 15.00],
            ['category' => 'Diner', 'name' => 'Kip Alfredo', 'description' => 'Gegrilde kip met fettuccine in een romige Alfredo saus', 'price' => 13.00],
            ['category' => 'Diner', 'name' => 'Ratatouille', 'description' => 'Traditionele Franse groentestoofpot met kruiden', 'price' => 11.00],
            ['category' => 'Diner', 'name' => 'Lasagne Bolognese', 'description' => 'Laagjes pasta met rundergehakt, tomatensaus en bechamel', 'price' => 13.50],
            ['category' => 'Diner', 'name' => 'Lamskoteletten', 'description' => 'Gekruide lamskoteletten met munt-yoghurt saus', 'price' => 17.00],
            ['category' => 'Diner', 'name' => 'Curry met Groenten', 'description' => 'Romige curry met seizoensgroenten', 'price' => 11.00],
            ['category' => 'Diner', 'name' => 'Mosselen met Friet', 'description' => 'Gestoomde mosselen in witte wijnsaus met frietjes', 'price' => 14.50],
            ['category' => 'Diner', 'name' => 'Gegrilde Aubergine', 'description' => 'Gegrilde aubergine met tahini en granaatappel', 'price' => 12.00],

            ['category' => 'Dessert', 'name' => 'Cheesecake', 'description' => 'Rijke en romige cheesecake met een graham cracker bodem', 'price' => 5.00],
            ['category' => 'Dessert', 'name' => 'Chocolademousse', 'description' => 'Lichte en luchtige chocolademousse', 'price' => 4.50],
            ['category' => 'Dessert', 'name' => 'Appeltaart', 'description' => 'Traditionele appeltaart met een krokante korts', 'price' => 4.00],
            ['category' => 'Dessert', 'name' => 'Citroentaart', 'description' => 'Frisse citroentaart met een boterachtige korst', 'price' => 4.50],
            ['category' => 'Dessert', 'name' => 'Brownie', 'description' => 'Een decadente chocoladebrownie', 'price' => 3.50],
            ['category' => 'Dessert', 'name' => 'Panna Cotta', 'description' => 'Zachte panna cotta met een vleugje vanille', 'price' => 4.00],
            ['category' => 'Dessert', 'name' => 'Tiramisu', 'description' => 'Klassieke Italiaanse tiramisu met mascarpone en koffie', 'price' => 5.50],
            ['category' => 'Dessert', 'name' => 'IJscoupe', 'description' => 'Drie bollen ijs naar keuze met slagroom', 'price' => 4.50],
            ['category' => 'Dessert', 'name' => 'Crème Brûlée', 'description' => 'Gebakken custard met een krokant suikerlaagje', 'price' => 5.00],
            ['category' => 'Dessert', 'name' => 'Chocolade Fondant', 'description' => 'Warme chocoladecake met een vloeibare kern', 'price' => 5.50],

            ['category' => 'Drank', 'name' => 'Americano', 'description' => 'Heet water met een shot espresso', 'price' => 2.50],
            ['category' => 'Drank', 'name' => 'Latte', 'description' => 'Geschuimde melk met een shot espresso', 'price' => 3.00],
            ['category' => 'Drank', 'name' => 'IJsthee', 'description' => 'Verfrissende koude thee met citroen', 'price' => 2.00],
            ['category' => 'Drank', 'name' => 'Sinaasappelsap', 'description' => 'Vers geperst sinaasappelsap', 'price' => 3.00],
            ['category' => 'Drank', 'name' => 'Rode Wijn', 'description' => 'Een glas rode wijn', 'price' => 5.00],
            ['category' => 'Drank', 'name' => 'Bier', 'description' => 'Pilsener bier', 'price' => 4.00],
            ['category' => 'Drank', 'name' => 'Cappucino' ,'description' => 'Espresso met gestoomde melk en melkschuim', 'price' => 3.00],
            ['category' => 'Drank', 'name' => 'Minerale Water', 'description' => 'Spa blauw of rood', 'price' => 2.00],
            ['category' => 'Drank', 'name' => 'Groene Thee', 'description' => 'Licht en verfrissende groente thee', 'price' => 2.50],
            ['category' => 'Drank', 'name' => 'Smoothie', 'description' => 'Vers fruit smoothie', 'price' => 4.00],
            ['category' => 'Drank', 'name' => 'Frisdrank', 'description' => 'Keuze uit cola, sinas, of lemon-lime', 'price' => 2.50],
            ['category' => 'Drank', 'name' => 'Chai Latte', 'description' => 'Gekruide thee met gestoomde melk', 'price' => 3.50],
            ['category' => 'Drank', 'name' => 'Milkshake', 'description' => 'Vanille, chocolade of aardbei milkshake', 'price' => 4.50],
            ['category' => 'Drank', 'name' => 'Mojito', 'description' => 'Verfrissende cocktail met munt en limoen', 'price' => 6.00],
            ['category' => 'Drank', 'name' => 'Whiskey', 'description' => 'Sterke drank van gerst of rogge', 'price' => 6.50],
            ['category' => 'Drank', 'name' => 'Koude Koffie', 'description' => 'Verfrissende koude koffie met slagroom', 'price' => 3.00],
            ['category' => 'Drank', 'name' => 'Appelsap', 'description' => 'Vers geperst appel', 'price' => 3.00],
            ['category' => 'Drank', 'name' => 'Warme Chocolade', 'description' => 'Warme chocolademelk met slagroom', 'price' => 3.50],
            ['category' => 'Drank', 'name' => 'Margarita', 'description' => 'Klassieke cocktail met tequila, limoen en triple sec', 'price' => 7.00],
            ['category' => 'Drank', 'name' =>'Thee', 'description' => 'Geserveerd in verschillende smaken', 'price' => 2.00]
        ];

        foreach ($items as $item) {
            Menu::create($item);
        }
    }
}
