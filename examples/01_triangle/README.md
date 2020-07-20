### Interpolartion Triangle 

The classic color gradient triangle.

[Goto Example Source](examples/01_triangle/)

```
$ php examples/01_triangle/triangle.php
```

| ![Triangle Example](examples/01_triangle/image.tga.png?raw=true) | ![Triangle Example](examples/01_triangle/image.tga.png?raw=true) |
|------------------------------------------------------------------|------------------------------------------------------------------|

This example exists to showcase the interpolation of the barycentric coordinates inside of a drawn triangle.

```php 
public function vertex(Vertex $vertex, array &$out) : Vec4
{
    $out['color'] = $vertex->color; // set the color attribute
    return Vec4::fromVec3($vertex->position); // return vertex positon
}

public function fragment(array &$in, array &$out)
{
    $out['color'] = $in['color']->toColorInt();
}
```
