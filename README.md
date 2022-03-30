# CodeIgniter3 IDE Helper

## TODO
- Create list of files that should be parsed
    - ./application/config/autoload.php
        - libraries
        - drivers ?
        - helpers ?
        - config ?
        - language ?
        - model
- Create reference from list of configurations into concrete classes
- Read list of files that should added doc. blocks into it
    - ./core/* ($this->load->*)
    - ./controllers/* ($this->load->*)
    - ./models/* ($this->load->*)
- Parse codes into AST, & extract list
- Write doc. blocks into CI_Model, CI_Controller
- Write doc. blocks into ./application/controllers & ./application/models
- Publish to Packagist
