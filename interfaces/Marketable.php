<?php


interface Marketable {
    
    public function buy(): void;  // Método para comprar un producto
    
    public function sell(): void;  // Método para vender un producto
    
    public function applyDiscount(int $percentage): void;  // Aplica un descuento porcentual al precio actual del producto.
    
    public function removeDiscount(): void;  // Elimina cualquier descuento aplicado, restaurando el precio original.
    
    public function increaseStock(int $amount): int;  // Aumenta el stock
    
    public function decreaseStock(int $amount): int;  // Disminuye el stock    
}
