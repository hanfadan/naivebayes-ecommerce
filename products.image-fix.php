<?php
require 'app/config/config.php';
require 'app/core/Database.php';
$db = new Database();

foreach ($db->get('products') as $p) {
    $img = $p['image'];
    // strip prefix 03_, 04_, 05_ kalau ada
    $clean = preg_replace('/^(0[3-5]_)/','',$img);
    if ($clean !== $img) {
        $db->where('id',$p['id'])
           ->update('products',['image'=>$clean]);
        echo "Cleaned {$p['id']}: {$img} → {$clean}\n";
    }
}
echo "Done normalizing images\n";
