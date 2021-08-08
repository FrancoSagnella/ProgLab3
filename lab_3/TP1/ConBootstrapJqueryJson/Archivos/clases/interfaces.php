<?php
    interface iArchivo
    {
        public function guardarEnArchivo($nombreArchivo);
        public function traerDeArchivo($nombreArchivo);
    }