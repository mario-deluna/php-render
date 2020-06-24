# PHP Render 

A 3D Software renderer in pure PHP.

 * No "pure php" cheating with FFI.
 * Just download/clone and the renderer should just work.
 * Has Shader System in PHP.
 * Allows Custom vertex attributes with interpolation.
 * Depth Buffer Support.
 * Support Multiple Output Buffers per context.

## Why?

Because this question is going to pop up a lot, let me address it here first. This project has been a learning experience for me and hopefully also for others interested in computer graphics with a web dev background. I should not have to say it but this has no "production value" whatsoever, there is a mountain of flaws to name a few:

 * This does not run in parallel. 
 * This runs on the CPU (Software Renderer).
 * This wastes insane amounts of memory.
 * I tried to optimize things without sacrificing too much code clarity, but this is still very slow. 
 * I use PHP Arrays as literal pixel buffers which just can't be optimal.

### So what is this?

I've been working on a game running in my own engine for a while now. Many of the issues I encountered came from not fully understanding what the rendering API (Vulkan, OpenGL, DirectX) actually does. To counter this I do what I always do, and try to implement the basics of the used library / API / concept myself. This project is the result. 

I should also note I'm still nowhere near an expert in the field. 

When I started with programming, I often encountered parts of computer science that seemed super interesting and I wanted to learn more about them. But not having examples/tutorials in a language I was familiar with got me overwhelmed fast. This is an issue that fades away after years in the industry but I still remember the frustration. Long story short I hope this project helps someone learning something new. 

## Examples

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

![Triangle Example](examples/01_triangle/image.tga.png?raw=true)

### Basic Cube

| ![Triangle Example](examples/01_triangle/image.tga.png?raw=true) | ![Triangle Example](examples/01_triangle/image.tga.png?raw=true) |
|------------------------------------------------------------------|------------------------------------------------------------------|

## Credits

- [Mario Döring](https://github.com/mario-deluna)
- [All Contributors](https://github.com/mario-deluna/php-render/contributors)

## License

The License (AGPLv3). Please see [License File](https://github.com/mario-deluna/php-render/blob/master/LICENSE) for more information.
