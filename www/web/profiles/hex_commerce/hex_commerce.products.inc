<?php
/**
 * @file
 * Product-related functions for the hex_commerce install tasks.
 */

use Drupal\commerce_price\Price;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductAttribute;
use Drupal\commerce_product\Entity\ProductAttributeValue;
use Drupal\commerce_product\Entity\ProductType;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_product\Entity\ProductVariationType;
use Drupal\commerce_store\Entity\Store;

/**
 * Create the product variation and attributes.
 */
function hex_commerce_prepare_products() {
  // Create the new variation type.
  $variation_type = ProductVariationType::create([
    'status' => 1,
    'id' => 'variation_type',
    'label' => 'Variation Type With Color',
    'orderItemType' => 'default',
    'generateTitle' => TRUE,
  ]);
  $variation_type->save();

  $attributes = hex_commerce_create_product_attributes($variation_type);

  $price = new Price('24.99', 'BRL');
  $price2 = new Price('39.99', 'BRL');

  $variation = ProductVariation::create([
    'type' => 'variation_type',
    'sku' => 'test-product-01',
    'status' => 1,
    'price' => $price,
    'attribute_color' => $attributes['color']['red'],
    'attribute_size' => $attributes['size']['p'],
  ]);
  $variation->save();

  $variation2 = ProductVariation::create([
    'type' => 'variation_type',
    'sku' => 'test-product-01',
    'status' => 1,
    'price' => $price2,
    'attribute_color' => $attributes['color']['yellow'],
    'attribute_size' => $attributes['size']['g'],
  ]);
  $variation2->save();

  hex_commerce_create_product_types([$variation, $variation2]);
}

/**
 * Create the product attributes.
 */
function hex_commerce_create_product_attributes(ProductVariationType $variation_type) {
  $color_attribute = ProductAttribute::create([
    'id' => 'color',
    'label' => 'color',
  ]);
  $color_attribute->save();

  $size_attribute = ProductAttribute::create([
    'id' => 'size',
    'label' => 'size',
  ]);
  $size_attribute->save();

  $field_manager = \Drupal::service('commerce_product.attribute_field_manager');
  $field_manager->createField($color_attribute, $variation_type->id());
  $field_manager->createField($size_attribute, $variation_type->id());

  $blue = ProductAttributeValue::create([
    'attribute' => 'color',
    'name' => 'blue',
  ]);
  $blue->save();

  $red = ProductAttributeValue::create([
    'attribute' => 'color',
    'name' => 'red',
  ]);
  $red->save();

  $yellow = ProductAttributeValue::create([
    'attribute' => 'color',
    'name' => 'yellow',
  ]);
  $yellow->save();

  $green = ProductAttributeValue::create([
    'attribute' => 'color',
    'name' => 'green',
  ]);
  $green->save();

  $p = ProductAttributeValue::create([
    'attribute' => 'size',
    'name' => 'p',
  ]);
  $p->save();

  $m = ProductAttributeValue::create([
    'attribute' => 'size',
    'name' => 'm',
  ]);
  $m->save();

  $g = ProductAttributeValue::create([
    'attribute' => 'size',
    'name' => 'g',
  ]);
  $g->save();

  return [
    'color' => [
      'blue' => $blue,
      'red' => $red,
      'yellow' => $yellow,
      'green' => $green,
    ],
    'size' => [
      'p' => $p,
      'm' => $m,
      'g' => $g,
    ],
  ];
}

/**
 * Create the product types.
 */
function hex_commerce_create_product_types(array $variations) {
  $product_type = ProductType::create([
    'id' => 'dress',
    'label' => 'Dress - color and size',
    'status' => 1,
    'description' => 'This is the description of the product',
    'variationType' => 'variation_type',
    'injectVariationFields' => TRUE,
  ]);
  $product_type->save();

  // These three functions must be called to add the appropriate fields to the type.
  commerce_product_add_variations_field($product_type);
  commerce_product_add_stores_field($product_type);
  commerce_product_add_body_field($product_type);

  $store = Store::load(1);

  $product = Product::create([
    'uid' => 1,
    'type' => 'dress',
    'title' => 'Dress 1',
    'stores' => [$store],
    'variations' => [$variations[0]],
  ]);
  $product->save();

  $product2 = Product::create([
    'uid' => 2,
    'type' => 'dress',
    'title' => 'Dress 2',
    'stores' => [$store],
    'variations' => [$variations[1]],
  ]);
  $product2->save();
}
