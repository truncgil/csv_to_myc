<?php
error_reporting(0);
// CSV verisini oku
$csvFile = 'data2.csv'; // CSV dosya adını buraya girin
$csvData = file_get_contents($csvFile);

// İlk satırda başlıkları ve kalan satırlarda verileri ayrıştır
//$headers = $csvData[0];
$csvData = explode("\n", $csvData);
unset($csvData[0]);

$trips = [];
$vin = "VR7EFYHZRLJ891520";

foreach ($csvData as $index => $row) {
    // Satır sayısı başlıklar ile eşleşmiyorsa hatayı atla

    $data = explode(";", $row);

    try {
       // Tarih ve saatleri oluştur
    $startDateTime = DateTime::createFromFormat('d/m/y H:i', $data[0] . ' ' . $data[1]);
    $endDateTime = DateTime::createFromFormat('d/m/y H:i', $data[0] . ' ' . $data[2]);

    // Trip verisini oluştur
    $trip = [
        "mergedTrips" => [],
        "idPims" => 1,
        "id" => 4381 + $index,
        "start" => [
            "street" => "",
            "streetNumber" => "",
            "intersection" => "",
            "city" => "",
            "postalCode" => "",
            "country" => "",
            "quality" => 255,
            "mileage" => (float) $data[3] - (float) $data[6],
            "altitude" => null,
            "longitude" => null,
            "latitude" => null,
            "date" => date('Y-m-d\TH:i:s.000\Z', strtotime($data[0] . ' ' . $data[1]))
        ],
        "end" => [
            "street" => "",
            "streetNumber" => "",
            "intersection" => "",
            "city" => "",
            "postalCode" => "",
            "country" => "",
            "quality" => 255,
            "mileage" => (float) $data[7],
            "altitude" => null,
            "longitude" => null,
            "latitude" => null,
            "date" => date('Y-m-d\TH:i:s.000\Z', strtotime($data[0] . ' ' . $data[2]))
        ],
        "destination" => [
            "street" => "",
            "streetNumber" => "",
            "intersection" => "",
            "city" => "",
            "postalCode" => "",
            "country" => "",
            "quality" => null,
            "mileage" => null,
            "altitude" => null,
            "longitude" => null,
            "latitude" => null,
            "date" => null
        ],
    ];

    $trips[] = $trip;
    } catch (\Throwable $th) {
        //throw $th;
    }
   
   
}

$jsonData = [
    "vin" => $vin,
    "trips" => $trips
];

// JSON verisini çıktı olarak yazdır
echo json_encode($jsonData, JSON_PRETTY_PRINT);

?>
