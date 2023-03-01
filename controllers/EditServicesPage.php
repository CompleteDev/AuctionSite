<?php

    class EditServicesPage extends Controller
    {
        public  function __construct()
        {
            $this->editServicesMDL = $this->model('EditServicesMDL');
        }

        public  function updateServices()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);
                $main_services = $_POST['main_services'];
                $main_text= $purifier->purify(trim($_POST['main_text']));
                $this->editServicesMDL->updateServices(ServiceSectionMain,$main_services,$main_text);
                $lm_services = $_POST['lm_services'];
                $lmservice_text = $_POST['lmservice_text'];
                $this->editServicesMDL->updateServices(ServiceSectionLandManagement,$lm_services,$lmservice_text);
                $lh_services = $_POST['lh_services'];
                $lhservice_text = $_POST['lhservice_text'];
                $this->editServicesMDL->updateServices(ServiceSectionLandHealth,$lh_services,$lhservice_text);
                $fin_services = $_POST['fin_services'];
                $fin_text = $_POST['fin_text'];
                $this->editServicesMDL->updateServices(ServiceSectionFinancialHealth,$fin_services,$fin_text);
                $rel_service = $_POST['rel_service'];
                $rel_text = $_POST['rel_text'];
                $this->editServicesMDL->updateServices(ServiceSectionRelationships,$rel_service,$rel_text);
            }
        }
    }