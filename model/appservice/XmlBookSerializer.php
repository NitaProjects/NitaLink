<?php
require_once '../model/products/Book.php';
require_once 'XmlSerializerBase.php';

class XmlBookSerializer extends XMLSerializerBase {
    public function serialize(Book $book): string {
        $bookData = [
            'productId' => $book->getProductId(),
            'name' => $book->getName(),
            'price' => $book->getPrice(),
            'quantity' => $book->getQuantity(),
            'author' => $book->getAuthor(),
            'pages' => $book->getPages(),
            'publisher' => $book->getPublisher(),
            'publishDate' => $book->getPublishDate()->format('Y-m-d'),
            'availabilityDate' => $book->getAvailabilityDate()->format('Y-m-d'),
            'physicalData' => $this->physicalDataToXmlArray($book->getPhysicalData())
        ];
        return $this->toXml($bookData);
    }

    public function unserialize(string $xmlString): Book {
        $data = $this->fromXml($xmlString);
        $physicalData = new PhysicalData(
            $data['physicalData']['height'],
            $data['physicalData']['width'],
            $data['physicalData']['length'],
            $data['physicalData']['weight'],
            $data['physicalData']['isFragile']
        );
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

    // Helper method for converting PhysicalData to an array
    private function physicalDataToXmlArray($physicalData) {
        return [
            'height' => $physicalData->getHeight(),
            'width' => $physicalData->getWidth(),
            'length' => $physicalData->getLength(),
            'weight' => $physicalData->getWeight(),
            'isFragile' => $physicalData->isFragile()
        ];
    }
}
