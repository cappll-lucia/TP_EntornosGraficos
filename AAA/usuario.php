<?php
    class Usuario {
        public $nombre;
        public $apellido;
        public $mail;
        public $legajo;
        public $id;
        public $tipoUsuario;

        function setNombre($nombre){
            $this->nombre = $nombre;
        }

        function getNombre(){
            return $this->nombre;
        }

        function setApellido($apellido){
            $this->apellido = $apellido;
        }

        function getApellido(){
            return $this->apellido;
        }

        function setMail($mail){
            $this->mail = $mail;
        }

        function getMail(){
            return $this->mail;
        }

        function setLegajo($legajo){
            $this->legajo = $legajo;
        }

        function getLegajo(){
            return $this->legajo;
        }

        function setId($id){
            $this->id = $id;
        }

        function getId(){
            return $this->id;
        }

        function setTipoUsuario($tipoUsuario){
            $this->tipoUsuario = $tipoUsuario;
        }

        function getTipoUsuario(){
            return $this->tipoUsuario;
        }

    }
