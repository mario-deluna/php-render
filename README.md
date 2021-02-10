# PHP Render 

A 3D Software renderer in pure PHP.

 * Just download/clone and the renderer should just work.
 * Has Shader System in PHP.
 * Allows Custom vertex attributes with interpolation.
 * Supports a Depth Buffer.
 * Supports Multiple Output Buffers per context.
 * CG Math Library.
 * ObJ File Parser.
 * Render to a mp4 video (requires ffmpeg)
 * No "pure php" cheating with FFI.

## Table of Contents

  * [Why?](#why)
    + [So what is this?](#so-what-is-this)
  * [Examples](#examples)
    + [Interpolartion Triangle](#interpolartion-triangle)
    + [Basic Cube](#basic-cube)
    + [Cube Video](#cube-video)
    + [Basic Model Loading](#basic-model-loading)
    + [Model With Texture Sampling](#model-with-texture-sampling)
  * [Credits](#credits)
  * [License](#license)

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

## Usage

Everything should be up and running, this renderer is implemented entirely in PHP so there are no special extension requirements or other dependencies.

Composer is used for autoloading so you will have to run a `composer install`.

Some examples make use of some assets (3d model, textures etc.) There is script which will download and extract these:

```
./bin/download-example-resources
```

## Examples

### Interpolartion Triangle 

The classic color gradient triangle.

[Example Source](examples/01_triangle/)

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

---
### Basic Cube

Just a simple cube showcasing 3D geometry with depth testing.


[Example Source](examples/02_cube_basic/)

```
$ php examples/02_cube_basic/cube.php
```

| ![Cube Lines](examples/02_cube_basic/image_lines.tga.png?raw=true) | ![Cube Depth](examples/02_cube_basic/image_depth.tga.png?raw=true) | ![Cube Color](examples/02_cube_basic/image.tga.png?raw=true) |
|---------------------------------------------|---------------------------------------------|---------------------------------------|

---
### Cube Video

Showcasing a simple example how to use the ffmpeg stream to create videos with php-render.

[Example Source](examples/02_cube_video/)

```
$ php examples/02_cube_video/cube.php
```

| ![Cube Lines](examples/03_cube_video/video.gif?raw=true) |
|-----------------------------------|

---
### Basic Model Loading 

This example shows how to load a model from an `obj` file.

[Example Source](examples/04_simple_model/)

```
$ php examples/04_simple_model/model.php
```

| ![Model Lines](examples/04_simple_model/image_lines.tga.png?raw=true) | ![Model Depth](examples/04_simple_model/image_depth.tga.png?raw=true) | ![Model Color](examples/04_simple_model/image.tga.png?raw=true) |
|---------------------------------------------|---------------------------------------------|---------------------------------------|

---
### Model With Texture Sampling

Showcases basic texture sampling of a loaded model.

[Example Source](examples/05_texture_sampling/)

```
$ php examples/05_texture_sampling/model.php
```


| ![Model Lines](examples/05_texture_sampling/image_lines.tga.png?raw=true) | ![Model Depth](examples/05_texture_sampling/image_depth.tga.png?raw=true) | ![Model Color](examples/05_texture_sampling/image.tga.jpg?raw=true) |
|---------------------------------------------|---------------------------------------------|---------------------------------------|

---
### Model with Phong Shading

Showcases simple phong shading on a 3D Model

[Example Source](examples/10_phong/)

```
$ php examples/10_phong/model.php
```


| ![Model Depth](examples/10_phong/image_depth.tga.png?raw=true) | ![Model Color](examples/10_phong/image.tga.png?raw=true)      | ![Video](examples/10_phong/video.gif?raw=true)          |
|----------------------------------------------|---------------------------------------------|---------------------------------------|

---
## Credits

- [Mario Döring](https://github.com/mario-deluna)
- [All Contributors](https://github.com/mario-deluna/php-render/contributors)

## License

The License (AGPLv3). Please see [License File](https://github.com/mario-deluna/php-render/blob/master/LICENSE) for more information.
