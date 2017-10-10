<?php
require_once 'persona.php';
require_once 'IGenericDAO.php';

use Slim\Http\UploadedFile;

class personaApi extends Persona implements IGenericDAO
{











    public function getById($request, $response, $args)
    {
        $personaid = $args['personaid'];
        $persona = Persona::getPersonaById($personaid);

        if (!$persona){
            $rv = new stdclass();
            $rv->message = "Recurso no encontrado";

            $ret_response = $response->withJson($rv, 404);
        }
        else{
            $ret_response = $response->withJson($persona, 200);
        }
        return $ret_response;
    }











    public function getAll($request, $response, $args)
    {
        $personas = Persona::getAllPersonas();

        $newResponse = $response->withJson($personas, 200);
        return $newResponse;
    }












    
    public function insert($request, $response, $args)
    {        
        $newPersonaData = $request->getParsedBody();
        /*  Cada solicitud HTTP tiene un cuerpo. Si está creando una aplicación Slim
        que consume datos JSON o XML, puede utilizar el método getParsedBody()
        del objeto Request de PSR 7 para analizar el cuerpo de solicitud HTTP
        en un formato PHP nativo. Slim puede analizar JSON, XML y datos codificados
        por URL fuera de la caja.   */        

        $passCrypt = crypt($newPersonaData["password"], "1af324D");
        /* http://php.net/manual/es/function.crypt.php */

        $newPersona = new Persona();
        $newPersona->nombre = ["nombre"];
        $newPersona->mail = $newPersonaData["mail"];
        $newPersona->password = $passCrypt;
        //[OPCIONAL] - $newPersona->password = crypt($newPersonaData["password"], "1af324D");
        $newPersona->foto = $newPersonaData["foto"];
        $newPersona->sexo = $newPersonaData["sexo"];

        $personaid = $newPersona->insertPersona();

        $rv = new stdclass();
        $rv->message = "Persona ingresada";
        
        return $response->withJson($rv, 200);

    }








    public function update($request, $response, $args)
    {
        $newData = $request->getParsedBody();
        $personaToUpdate = new Persona();
        $personaToUpdate->id = $newData['id'];
        $personaToUpdate->nombre = $newData['nombre'];
        $personaToUpdate->mail = $newData['mail'];
        $personaToUpdate->password = crypt($newData['password'], "1af324D");
        $personaToUpdate->foto = $newData['foto'];
        $personaToUpdate->sexo = $newData['sexo'];
        $rv = new stdclass();

        if ($personaToUpdate->updatePersona())
        {
            $rv->message = "El persona ha sido actualizado con exitosamente.";
            $newResponse = $response->withJson($rv, 200);
        }
        else
        {
            $rv->message = "Hubo un error y no se ha podido actualizar. Comuniquese con el administrador de su sistema.";
            $newResponse = $response->withJson($rv, 404);
        }

        return $newResponse;
    }








    
    public function delete($request, $response, $args)
    {
        $personaToDelete = $request->getParsedBody();
        $persona = new Persona();
        $rv = new stdclass();

        $id = $personaToDelete['id'];
        $persona->id = $id;        

        if ($persona->deletePersona() > 0)
        {
            $rv->message = "Persona eliminado exitosamente.";
            $response = $response->withJson($rv, 200);
        }
        else
        {
            $rv->message = "Persona no encontrado.";
            $response = $response->withJson($rv, 404);
        }


        return $response;
    }








    //SignIn
    public function validatePersona($request, $response, $args)
    {
        try {
            $rv = new stdclass();

            $personaData = $request->getParsedBody();

            $password = crypt($personaData['password'], "1af324D");
            $email = $personaData['mail'];

            $persona = Persona::getPersonaDataByEmailAndPassword($email, $password);

            
            if ($persona != false)
            {
                $jwt = AuthJWT::getToken($persona);
                $rv->jwt = $jwt;
                $rv->message = 'Persona encontrado';
                $response = $response->withJson($rv, 200);
            }
            else
            {
                $rv->message = "El persona no ha sido encontrado";
                $response = $response->withJson($rv, 200);
            }


            return $response;

        } catch (Exception $ex) {
            $rv->message = "Error desconocido. Comuniquese con el administrador de su sistema.";
            $response = $response->withJson($rv, 404);
            return $response;

        }

    }










    //SignUp
    function registerPersona($request, $response, $args)
    {
        $rv = new stdclass();

        $personaData = $request->getParsedBody();
        $password = $personaData['password'];
        $email = $personaData['email'];

        if (Persona::personaAlreadyExist($email)) {
            $rv->message = "El persona ingresado ya existe";
            $response = $response->withJson($rv, 404);
        }
        else {
            $response = $this->insert($request, $response, $args);
            $persona = new stdclass();
            $persona->password = $password;
            $persona->email = $email;
            $jwt = AuthJWT::getToken($persona);
            $rv->message = "Persona registrado exitosamente";
            $rv->jwt = $jwt;
            $response = $response->withJson($rv, 200);
        }
        return $response;
    }











    //Para foto
    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}