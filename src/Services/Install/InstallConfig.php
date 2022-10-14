<?php

namespace App\Services\Install;

use App\Command\Install\Functionality;
use App\Command\Install\Module;
use App\Command\Install\Role;

class InstallConfig 
{
    //Modulos -------------------------------------------------------------------------------------------

    /**
     * Define una Lista de Modulos
     * 
     * For create one -> Module::createModule($moduleKey, string $name, string $description = null)
     *
     * @return Module[]
     */
    public static function defineModules() : array
    {
        $modules = array();    
       
        //Administración
        $modules[] = Module::createModule("MODULE_ADMIN", "Módulo de Administración", "Módulo de administración");
        $modules[] = Module::createModule("MODULE_PERSON", "Módulo de Personal", "Módulo de personal");
        $modules[] = Module::createModule("MODULE_PLANING", "Módulo de Planificación", "Módulo de planificación estratégica");
        $modules[] = Module::createModule("MODULE_STRUCT", "Módulo de Estructura", "Módulo de estrucutra y composición");
        $modules[] = Module::createModule("MODULE_PLACT", "Módulo de Plan de Actividaeds", "Módulo de plan de actividades y tareas");
        $modules[] = Module::createModule("MODULE_REPORT", "Módulo de Reportes", "Módulo de reportes");
        $modules[] = Module::createModule("MODULE_TRACE", "Módulo de Trazas", "Módulo de trazas");      

        return $modules;
    }



    //Funcionaliades -------------------------------------------------------------------------------------------

    /**
     * Define una Lista de Funcionalidades para Comunes
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_ADMIN", "Módulo de Administración")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesComunes() : array
    {
        $functionalities = array();    
       
        //Administración
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_PORTADA_ADMIN", "Portada General de Administración", "Para el acceso principal al la Portada de Administración");

        return $functionalities;
    }

    
    /**
     * Define una Lista de Funcionalidades para Administracion
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_ADMIN", "Módulo de Administración")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForAdministracion() : array
    {
        $functionalities = array();    
       
        //Administración        
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_HOME_ADMIN", "Portada de Administración", "Portada principal de administración");
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_GEST_USER", "Gestionar usuarios", "Gestionar usuarios");
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_GEST_FUNC", "Gestionar funcionalidades", "Gestionar funcionalidades del sistema");
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_GEST_MODULE", "Gestionar módulos", "Gestionar módulos del sistema");
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_GEST_ROLES", "Gestionar roles", "Gestionar los roles del sistema");    
        $functionalities[] = Functionality::createFunctionality("MODULE_ADMIN", "ROLE_GEST_CHAT", "Gestionar chat", "Gestionar y sincronizar los usuarios del chat");  

        return $functionalities;
    }


     /**
     * Define una Lista de Funcionalidades para Personal
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_PERSONAL", "Módulo de Personal")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForPersonal() : array
    {
        $functionalities = array(); 

        //Personal
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_HOME_PERSONAL", "Portada de Personal", "Portada principal de personal");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_CARRERA", "Gestionar carreras", "Gestionar carreras");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_CATDOC", "Gestionar categorías docentes", "Gestionar categorías docentes");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_CATINVST", "Gestionar categorías investigativas", "Gestionar categorías investigativas");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_CLAPER", "Gestionar clasificación de persona", "Gestionar clasificación de persona");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_GRADAKAD", "Gestionar grados académicos", "Gestionar grados académicos");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_NIVESC", "Gestionar nivel escolar", "Gestionar nivel escolar");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_ORGANZ", "Gestionar organizaciones", "Gestionar organizaciones");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_PERSON", "Gestionar personas", "Gestionar personas");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_PROF", "Gestionar profesiones", "Gestionar profesiones");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_RESPONS", "Gestionar responsables", "Gestionar responsables");
        $functionalities[] = Functionality::createFunctionality("MODULE_PERSON", "ROLE_GEST_TYPORG", "Gestionar tipos de organización", "Gestionar tipos de organización");
             
       
        return $functionalities;
    }

     /**
     * Define una Lista de Funcionalidades para Estructura
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_ESTRUCTURA", "Módulo de Estructura")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForEstructura() : array
    {
        $functionalities = array(); 

        //Estructura        
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_HOME_STRUCT", "Portada principal de estructura", "Portada principal de estructura"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_CATGEST", "Gestionar categorías de estructura", "Gestionar categorías de estructura"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_CATRESP", "Gestionar categorías de responsabilidad", "Gestionar categorías de responsabilidad"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_ENTITY", "Gestionar entidades", "Gestionar entidades"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_ESTRUCT", "Gestionar estructuras", "Gestionar estructuras"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_MUNICP", "Gestionar municipios", "Gestionar municipios"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_PROVIN", "Gestionar provincias", "Gestionar provincias"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_RESPON", "Gestionar responsabilidades", "Gestionar responsabilidades"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_TYPENTY", "Gestionar tipos de entidad", "Gestionar tipos de entidad"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_STRUCT", "ROLE_GEST_TYPEESTR", "Gestionar tipos de estructura", "Gestionar tipos de estructura"); 


        return $functionalities;
    }

    /**
     * Define una Lista de Funcionalidades para Plan de Actividades
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_PLAN_ACTIVIDADES", "Módulo de Plan de Actividades")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForPlanActividades() : array
    {
        $functionalities = array(); 

        //Plan Actividades
        $functionalities[] = Functionality::createFunctionality("MODULE_PLACT", "ROLE_HOME_ACTV", "Portada principal de plan de activiades", "Portada principal de plan de actividades"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLACT", "ROLE_GEST_ACTV", "Gestionar activides", "Gestionar actividades en el calendario"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLACT", "ROLE_GEST_ESTACTV", "Gestionar estado de activides", "Gestionar estado de activides"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLACT", "ROLE_GEST_NOTAS_ACTIV", "Gestionar notas de activides", "Gestionar notas de activides"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLACT", "ROLE_GEST_TYPACTIV", "Gestionar tipos de activides", "Gestionar tipos de activides"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLACT", "ROLE_GEST_TODOLIST", "Gestionar lista de tareas", "Gestionar lista de tareas"); 
             

        return $functionalities;
    }

    /**
     * Define una Lista de Funcionalidades para Planeación
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_PLANEACION", "Módulo de Planeación")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForPlaneacion() : array
    {
        $functionalities = array(); 

        //Planeacion
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_HOME_PLAN", "Portada principal de plan de estratégica", "Portada principal de plan de estratégica"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_ARC", "Gestionar área de resultados claves", "Gestionar área de resultados claves"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_EVAL", "Gestionar evaluaciones", "Gestionar evaluaciones"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_FREVAL", "Gestionar forma de evaluación", "Gestionar forma de evaluación"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_INDIC", "Gestionar indicadores", "Gestionar indicadores"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_OBJESPC", "Gestionar objetivos específicos", "Gestionar objetivos específicos"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_GENER", "Gestionar objetivos generales", "Gestionar objetivos generales"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_PLAN", "Gestionar planes", "Gestionar planes"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_EJCPLAN", "Gestionar ejecución del planes", "Gestionar ejecución del planes"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_TYPEVAL", "Gestionar tipos de evaluación", "Gestionar tipos de evaluación"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_TYPIND", "Gestionar tipos de indicador", "Gestionar tipos de indicador"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_UNMED", "Gestionar unidades de medidas", "Gestionar unidades de medidas"); 
        $functionalities[] = Functionality::createFunctionality("MODULE_PLANING", "ROLE_GEST_INCUMPL", "Gestionar incumplimientos", "Gestionar incumplimientos");


        return $functionalities;
    }

    /**
     * Define una Lista de Funcionalidades para Reporte
     * 
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_REPORTE", "Módulo de Reporte")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForReporte() : array
    {
        $functionalities = array(); 

        //Reporte
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_HOME_REPORT", "Portada principal a reportes", "Portada principal a reportes");
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_ESTPL_REP", "Reporte de estado del plan", "Reporte de estado del plan");
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_MAPIND_REP", "Reporte de indicadores en el mapa", "Reporte de indicadores en el mapa");
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_PROGRAM_REP", "Reporte del programa", "Reporte del programa");
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_CUSTOM_REP", "Reporte personalizado", "Reporte personalizado");
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_RESPONS_REP", "Reporte de responsables", "Reporte de responsable");
        $functionalities[] = Functionality::createFunctionality("MODULE_REPORT", "ROLE_OBSERV_REP", "Reporte de causas de los indicadores evaluados de mal, regular y no evaluados", "Reporte de causas de los indicadores evaluados de mal, regular y no evaluados");


        return $functionalities;
    }


    /**
     * Define una Lista de Funcionalidades para Trazas
     *
     * For create one -> Functionality::createFunctionality("ROLE_MODULO_REPORTE", "Módulo de Trazas")
     *
     * @return Functionality[]
     */
    public static function defineFunctionalitiesForTrazas() : array
    {
        $functionalities = array();

        //Traza
        $functionalities[] = Functionality::createFunctionality("MODULE_TRACE", "ROLE_HOME_TRAZAS", "Portada principal a trazas", "Portada principal a trazas");
        $functionalities[] = Functionality::createFunctionality("MODULE_TRACE", "ROLE_ACCTION_TRZ", "Gestionar acciones de las trazas", "Gestionar acciones de las trazas");
        $functionalities[] = Functionality::createFunctionality("MODULE_TRACE", "ROLE_OBJ_TRZ", "Gestionar objetos de las trazas", "Gestionar objetos de las trazas");
        $functionalities[] = Functionality::createFunctionality("MODULE_TRACE", "ROLE_TYPTRZ", "Gestionar tipos de trazas", "Gestionar tipos de trazas");
        $functionalities[] = Functionality::createFunctionality("MODULE_TRACE", "ROLE_TRAZ", "Gestionar trazas", "Gestionar trazas");
        

        return $functionalities;
    }



    //Roles -------------------------------------------------------------------------------------------

    /**
     * Define una Lista de Modulos
     * 
     * For create one -> Role::createRole($roleKey, string $name, string $description = null)
     *                      ->addFunctionality('Funct1')
     *                      ->addFunctionalities('Funct2', 'Funct3')
     *
     * @return Module[]
     */
    public static function defineRoles() : array
    {
        $roles = array();    
       
        $roles[] = Role::createRole('ROL_ADMIN', "Administrador de Seguridad", "Rol con permisos a las gestiones administrativas de seguridad")
                        ->addFunctionality("ROLE_PORTADA_ADMIN")                        
                        ->addFunctionality("ROLE_HOME_ADMIN")
                        ->addFunctionality("ROLE_GEST_USER")
                        ->addFunctionality("ROLE_GEST_FUNC")
                        ->addFunctionality("ROLE_GEST_MODULE")                                            
                        ->addFunctionality("ROLE_GEST_ROLES")   
                        ->addFunctionality("ROLE_GEST_CHAT")     
        ;

        $roles[] = Role::createRole('ROL_STRUCT', "Administrador de Estructura y Composición", "Rol con permisos a todas las funcionalidades de estructura y composición")
                        ->addFunctionality("ROLE_PORTADA_ADMIN")  
                        ->addFunctionality("ROLE_HOME_STRUCT")                     
                        ->addFunctionality("ROLE_GEST_CATGEST")
                        ->addFunctionality("ROLE_GEST_CATRESP")
                        ->addFunctionality("ROLE_GEST_ENTITY")
                        ->addFunctionality("ROLE_GEST_ESTRUCT")
                        ->addFunctionality("ROLE_GEST_MUNICP")
                        ->addFunctionality("ROLE_GEST_PROVIN")
                        ->addFunctionality("ROLE_GEST_RESPON")
                        ->addFunctionality("ROLE_GEST_TYPENTY")
                        ->addFunctionality("ROLE_GEST_TYPEESTR")
        ;

        $roles[] = Role::createRole('ROL_PERSON', "Administrador de Personal", "Rol con permisos a todas las funcionalidades de personal")
                        ->addFunctionality("ROLE_PORTADA_ADMIN")  
                        ->addFunctionality("ROLE_HOME_PERSONAL")                         
                        ->addFunctionality("ROLE_GEST_CARRERA")  
                        ->addFunctionality("ROLE_GEST_CATDOC")  
                        ->addFunctionality("ROLE_GEST_CATINVST")  
                        ->addFunctionality("ROLE_GEST_CLAPER")  
                        ->addFunctionality("ROLE_GEST_GRADAKAD")  
                        ->addFunctionality("ROLE_GEST_NIVESC")  
                        ->addFunctionality("ROLE_GEST_ORGANZ")  
                        ->addFunctionality("ROLE_GEST_PERSON")  
                        ->addFunctionality("ROLE_GEST_PROF")  
                        ->addFunctionality("ROLE_GEST_RESPONS")          
                        ->addFunctionality("ROLE_GEST_TYPORG")                         
        ;

        $roles[] = Role::createRole('ROL_PLANACTIV', "Administrador de Plan de Actividades", "Rol con permisos a todas las funcionalidades de plan de actividades")
                        ->addFunctionality("ROLE_PORTADA_ADMIN")       
                        ->addFunctionality("ROLE_HOME_ACTV")  
                        ->addFunctionality("ROLE_GEST_ACTV")  
                        ->addFunctionality("ROLE_GEST_ESTACTV")  
                        ->addFunctionality("ROLE_GEST_NOTAS_ACTIV")  
                        ->addFunctionality("ROLE_GEST_TYPACTIV")  
                        ->addFunctionality("ROLE_GEST_TODOLIST")                                                                    
        ;

        $roles[] = Role::createRole('ROL_PLANAEST', "Administrador de Planificación Estratégica", "Rol con permisos a todas las funcionalidades de planificación estratégica")
                        ->addFunctionality("ROLE_PORTADA_ADMIN")   
                        ->addFunctionality("ROLE_HOME_PLAN") 
                        ->addFunctionality("ROLE_GEST_ARC") 
                        ->addFunctionality("ROLE_GEST_EVAL") 
                        ->addFunctionality("ROLE_GEST_FREVAL") 
                        ->addFunctionality("ROLE_GEST_INDIC") 
                        ->addFunctionality("ROLE_GEST_OBJESPC")     
                        ->addFunctionality("ROLE_GEST_GENER")  
                        ->addFunctionality("ROLE_GEST_PLAN")  
                        ->addFunctionality("ROLE_GEST_EJCPLAN")   
                        ->addFunctionality("ROLE_GEST_TYPEVAL")  
                        ->addFunctionality("ROLE_GEST_TYPIND")  
                        ->addFunctionality("ROLE_GEST_UNMED")                                                                         
        ;

        $roles[] = Role::createRole('ROL_REPORT', "Visualizador de Reportes", "Rol con permisos a todos los reportes")
                        ->addFunctionality("ROLE_PORTADA_ADMIN")   
                        ->addFunctionality("ROLE_HOME_REPORT")    
                        ->addFunctionality("ROLE_ESTPL_REP")    
                        ->addFunctionality("ROLE_MAPIND_REP")    
                        ->addFunctionality("ROLE_PROGRAM_REP")                                                                                              
        ;

        $roles[] = Role::createRole('ROL_TRAZ', "Administrador de Trazas", "Rol con permiso a las trazas del sistema")                     
                        ->addFunctionality("ROLE_PORTADA_ADMIN")   
                        ->addFunctionality("ROLE_ACCTION")    
                        ->addFunctionality("ROLE_OBJ_TRZ")  
                        ->addFunctionality("ROLE_TYPTRZ")  
                        ->addFunctionality("ROLE_HOME_TRAZAS")                                                                                         
        ;
         

        return $roles;
    }
}