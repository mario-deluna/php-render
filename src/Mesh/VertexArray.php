<?php 

namespace PHPR\Mesh;

use PHPR\Math\Vec3;

class VertexArray
{
    /**
     * An array of verices
     */
    public array $vertices = [];

    /**
     * Vertex class
     */
    private string $vertexClass;

    /**
     * Construct a vertex array
     *
     * @param string            $vertexClass
     * @param array             $data
     */
    public function __construct(string $vertexClass, array $data)
    {
        $this->vertexClass = $vertexClass;
        $this->appendData($data);
    }

    /**
     * Add an array of data 
     *
     * @param array                 $data
     */
    public function appendData(array $data)
    {
        $vc = $this->vertexClass;

        $chunks = array_chunk($data, $vc::size());

        foreach($chunks as $list) {
            $this->vertices[] = $vc::list($list);
        }
    }

    /**
     * Get all vertices
     */
    public function getVertices() : array
    {
        return $this->vertices;
    }
}
