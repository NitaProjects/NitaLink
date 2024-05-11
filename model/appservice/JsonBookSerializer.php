<?php


class JsonBookSerializer {
  
    public function serialize(Book $book): string {
        return json_encode($book);
    }

    public function unserialize(string $jsonString): Book {
        $data = json_decode($jsonString, true);
        $physicalData = isset($data['physicalData']) ? new PhysicalData(
            $data['physicalData']['height'],
            $data['physicalData']['width'],
            $data['physicalData']['length'],
            $data['physicalData']['weight'],
            $data['physicalData']['isFragile'] ?? false
        ) : null;

        return new Book(
            $data['name'],
            $data['price'],
            $data['productId'],
            $data['quantity'],
            $data['author'],
            $data['pages'],
            $data['publisher'],
            $data['publishDate'],
            $data['availabilityDate'],
            $physicalData
        );
    }
}
