### Interpolartion Triangle 

The classic color gradient triangle.

```php 
public function vertex(Vertex $vertex, array &$out)
{
    $out['position'] = $vertex->position;
    $out['color'] = $vertex->color;
}

public function fragment(array &$in, array &$out)
{
    $out['color'] = $in['color']->toColorInt();
}
```

| ![Triangle Example](examples/01_triangle/image.tga.png?raw=true) | ![Triangle Example](examples/01_triangle/image.tga.png?raw=true) |
|------------------------------------------------------------------|------------------------------------------------------------------|
