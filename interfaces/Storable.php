<?php

interface Storable {
    // Métodos para productos físicos
    public function getHeight(): ?float; 
    
    public function getWidth(): ?float;
    
    public function getLength(): ?float;
    
    public function getWeight(): ?float;
    
    public function isFragile(): ?bool;
    
    public function getVolume(): ?float; // Calculated as W*L*H
    
    public function getDimensions(): ?string; // Format: W:1; L:2.2; H:3.1
}

