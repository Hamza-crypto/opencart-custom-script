<?php

class ProductController
{
    public $conn;
    public $table_name = 'custom_products';
    public $BASE_URL = 'http://localhost/opencart';

    public function __construct()
    {
        include '../config.php';
        $this->conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    }

    public function getProducts()
    {
        $sql = "SELECT * FROM $this->table_name";
        return mysqli_query($this->conn, $sql);
    }

    public function storeProduct($soft_cap, $product_id, $link)
    {
        $sql = "INSERT INTO $this->table_name (soft_cap, eshop_id, url) VALUES ('$soft_cap', '$product_id', '$link')";
        $result = mysqli_query($this->conn, $sql);

        if ($result) {
            echo "Product created successfully";
        } else {
            echo "Error creating product";
        }
    }

    public function updateSoftCap($product_id, $softcap)
    {
        if ($softcap == "") $softcap = "null";
        $sql = "UPDATE $this->table_name SET soft_cap = $softcap WHERE id = $product_id";
        return mysqli_query($this->conn, $sql);
    }

    public function updateIgnoreStatus($product_id, $ignore)
    {
        $sql = "UPDATE $this->table_name SET ignored = $ignore WHERE id = $product_id";
        return mysqli_query($this->conn, $sql);
    }

    public function deleteProduct($product_id)
    {
        $sql = "DELETE FROM $this->table_name WHERE id = $product_id";
        return mysqli_query($this->conn, $sql);

    }

    function scrape()
    {
        $sql = "SELECT * FROM $this->table_name WHERE ignored = 0";
        $products = mysqli_query($this->conn, $sql);

        while ($product = mysqli_fetch_object($products)) {
            $product_new_price = $this->getAPIResponse($product->url);
            $product_new_price = (float)str_replace(',', '.', str_replace('€', '', $product_new_price));

            $product_new_price = $product_new_price - 0.01;

            if ($product_new_price < $product->soft_cap) {
                echo "Price is less than soft cap for product ID: $product->eshop_id \n";
                $current_price = $this->sendRequest("$this->BASE_URL/app/update_opencart_price.php?product_id=$product->eshop_id", []);

                $sql = "UPDATE $this->table_name SET price = $current_price WHERE eshop_id = $product->eshop_id";
                mysqli_query($this->conn, $sql);
                continue;
            }

            $this->sendRequest("$this->BASE_URL/app/update_opencart_price.php", [
                'product_id' => $product->eshop_id,
                'price' => $product_new_price
            ], 'POST');

            $sql = "UPDATE $this->table_name SET price = $product_new_price WHERE id = $product->id";
            mysqli_query($this->conn, $sql);
            echo "Price updated for product ID: $product->eshop_id \n";


        }


    }

    public function getAPIResponse($url)
    {
        $url = "https://app.scrapingbee.com/api/v1/?api_key=M0X68R92D437A7AZ1AVCFEFQGVWJTI9FHEPCZBF41163TYLFV24LH97TCCM05SQZNVNRCCN1K3KK4&url=$url";
        $url = "http://localhost:65";
        $full_page_html = file_get_contents($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($full_page_html);
        $price = $dom->getElementById("prices")->getElementsByTagName("li")[0]->getElementsByTagName('strong')[0]->textContent;
        return $price;
    }

    public function sendRequest($url, $fields, $method = 'GET')
    {
        $fields_string = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        return $result;
    }


}
