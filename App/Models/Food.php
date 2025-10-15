<?php

namespace App\Models;

class Food
{
    protected ?int $id;
    public int $food_type_id;
    public string $name;
    public ?string $description;
    public ?string $ingredients;
    public ?float $price;
    public ?string $created_at;
    
    public function __construct(
        ?int $id, 
        int $food_type_id, 
        string $name, 
        ?string $description = null, 
        ?string $ingredients = null, 
        ?float $price = null,
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->food_type_id = $food_type_id;
        $this->name = $name;
        $this->description = $description;
        $this->ingredients = $ingredients;
        $this->price = $price;
        $this->created_at = $created_at;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getFoodTypeId(): int
    {
        return $this->food_type_id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }
    
    public function getPrice(): ?float
    {
        return $this->price;
    }
    
    public function getFormattedPrice(): string
    {
        return $this->price ? number_format($this->price, 0) . ' Ft' : 'Ár egyeztetés szerint';
    }
    
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
    
    public function displayFood(): string
    {
        $priceText = $this->getFormattedPrice();
        $desc = $this->description ? " - {$this->description}" : "";
        return "{$this->name}{$desc} | Ár: {$priceText}";
    }
}