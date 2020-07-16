<?php 

namespace PHPR\Mesh;

use Exception;
use PHPR\Mesh\Vertex\VertexPNU;

class ObjParser
{ 
    /**
     * Load an object file from disk
     *
     * @param string            $path
     */
    public static function loadFromDisk(string $path)
    {
        if (!file_exists($path)) {
            throw new \Exception("Cannot find requested object file: " . $path);
        }

        $parser = new ObjParser;
        return $parser->parse(file_get_contents($path));
    }


    /**
     * Parse the given obj file content to a Textured Mesh
     *
     * @param string            $content
     * @return TexturedMesh
     */
    public function parse(string $content)
    {
        $content = explode("\n", $content);

        $vertices = [];
        $uvs = [];
        $normals = [];

        $faces = [];

        foreach($content as $line)
        {
            // skip empty lines
            if (empty($line)) continue;

            // skip with no space
            if (($p = strpos($line, ' ')) !== false);

            // get the type
            $type = substr($line, 0, $p);
            $data = trim(substr($line, $p + 1));

            // vertices
            if ($type === 'v')
            {
                $vertices[] = array_map('floatval', explode(' ', $data));
            }
            elseif ($type === 'vt')
            {
                $uvs[] = array_map('floatval', explode(' ', $data));
            }
            elseif ($type === 'vn')
            {
                $normals[] = array_map('floatval', explode(' ', $data));
            }
            elseif ($type === 'f')
            {
                $faces[] = array_map(function($f) 
                {
                    return array_map('intval', explode('/', $f));
                }, explode(' ', $data));
            }
        }

        // prepare the data for a mesh
        $data = [];

        foreach($faces as $face)
        {
            foreach($face as list($vi, $ui, $ni))
            {
                // add the positon
                foreach($vertices[$vi - 1] as $c)
                {
                    $data[] = $c;
                }

                // add the normals
                foreach($normals[$ni - 1] as $c)
                {
                    $data[] = $c;
                }

                // add the texture coords
                for($a = 0; $a<2; $a++) {
                    $data[] = $uvs[$ui - 1][$a];
                }
            }
        }

        return new VertexArray(VertexPNU::class, $data);
    }
}
