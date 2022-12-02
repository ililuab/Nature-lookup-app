<?php  
get_header();
/* Template Name: Resultaten */
?>
<?php if (isset($_GET['locatie'])):
    $locatie = $_GET['locatie'];
endif;
?>
<div class="container-fluid p-0">
    <div class="row p-0 m-0 logo">
        <div class="text-center col">
            <a href="http://test2.local/"><?php $image = get_field('logo'); echo wp_get_attachment_image($image['ID'], 'logo', false);?></a></div>
        </div>
        <div class="row text-center p-0 m-0 title-row">
            <div class="col z-index-1">
                <h1 class="titel mb-3"><?= get_field('results_top_h1') ?></h1>
                <p class="description"><?= get_field('results_top_p') ?></p>
            </div> 
        </div>
        <?php $results_video = get_field('resultaten_video');?>
        <video class="results_video" src="<?= $results_video['url']; ?>"  autoplay loop muted></video>
    </div>



    <?php
    $curl = curl_init();
    curl_setopt_array($curl, [
    CURLOPT_URL => 'https://api.geoapify.com/v1/geocode/autocomplete?text='. $locatie .'&format=json&apiKey=25e418be0dda4bc282274deeb7e1e148', 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
]);
$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response);
$items = !empty($response->results) ? $response->results : false;
if($items):
    foreach($items as $item):
        $place_ID = !empty($item->place_id) ? $item->place_id : false;    
            endforeach;
        else:
            return;
        endif;
        ?>
<div class="container-fluid p-0">
<?php
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.geoapify.com/v2/places?categories=natural&filter=place:'. $place_ID .'&limit=500&apiKey=25e418be0dda4bc282274deeb7e1e148',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));
$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response);
$items = !empty($response->features) ? $response->features : false;

?><div class="p-0 m-0 row">
<div class="mb-5 col-12 col_results"><?php
if($items):
    foreach($items as $item):
        $natuur_gebied = !empty($item->properties->name) ? $item->properties->name : false;
        $land = !empty($item->properties->country) ? $item->properties->country : false;
        $adress = !empty($item->properties->address_line2) ? $item->properties->address_line2 : false;
        $lon = !empty($item->properties->lon) ? $item->properties->lon : false;
        $lat = !empty($item->properties->lat) ? $item->properties->lat : false;
         if($land && $natuur_gebied && $adress): ?>
        <div class="mb-5 card">
        <iframe class="card-img-top" src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d459539.20982941095!2d<?= $lon; ?>!3d<?= $lat; ?>!3m2!1i1024!2i768!4f13.1!5e1!3m2!1snl!2snl!4v1666864833237!5m2!1snl!2snl" width="455.9" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="card-body kaart">
            <h5 class="card-title"><?= $land ?></h5>
            <p class="card-title"><?= $natuur_gebied ?></p>
            <p class="card-text"><?= $adress ?></p>
            <a class="btn btn-outline-success" href="https://www.google.nl/maps/place/40%C2%B037'01.1%22N+74%C2%B001'09.7%22W/@40.6169685,-74.0215607,30z/data=!3m1!4b1!4m5!3m4!1s0x0:0xecab6fd01d2780de!8m2!3d40.6169685!4d-74.019372">Bekijk locatie</a>
            </div>
        </div>
            <?php endif; ?>
    <?php endforeach; ?>
</div><?php
    else:
        return;
    endif; ?> 
</div>
</div>