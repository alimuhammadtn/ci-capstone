<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Education_model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'educations';
                $this->primary_key = 'education_id';

                $this->before_create[] = '_add_created_by';
                $this->before_update[] = '_add_updated_by';

                $this->_relations();
                $this->_form();
                $this->_config();

                parent::__construct();
        }

        protected function _add_created_by($data)
        {
                $data['created_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        protected function _add_updated_by($data)
        {
                $data['updated_user_id'] = $this->ion_auth->get_user_id(); //add user_id
                return $data;
        }

        private function _config()
        {
                $this->timestamps        = TRUE; //(bool) $this->config->item('my_model_timestamps');
                $this->return_as         = 'object'; //$this->config->item('my_model_return_as');
                $this->timestamps_format = 'timestamp'; //$this->config->item('my_model_timestamps_format');


                $this->cache_driver         = 'file'; //$this->config->item('my_model_cache_driver');
                $this->cache_prefix         = 'cicapstone'; //$this->config->item('my_model_cache_prefix');
                /**
                 * some of field is not required, so remove it in array when no value, in inside the *->from_form()->insert() in core MY_Model,
                 */
                // $this->remove_empty_before_write = TRUE;//(bool) $this->config->item('my_model_remove_empty_before_write');
                $this->delete_cache_on_save = TRUE; //(bool) $this->config->item('my_model_delete_cache_on_save');
        }

        private function _relations()
        {
                $this->has_one['user_created'] = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'created_user_id'
                );
                $this->has_one['user_updated'] = array(
                    'foreign_model' => 'User_model',
                    'foreign_table' => 'users',
                    'foreign_key'   => 'id',
                    'local_key'     => 'updated_user_id'
                );
                $this->has_many['course']      = array(
                    'foreign_model' => 'Course_model',
                    'foreign_table' => 'courses',
                    'foreign_key'   => 'course_id',
                    'local_key'     => 'course_id'
                );
        }

        private function _form()
        {

                $this->rules = array(
                    'insert' => array(
                        'education_code'        => array(
                            'label'  => lang('create_education_code_label'),
                            'field'  => 'code',
                            'rules'  => 'trim|required|is_unique[educations.education_code]|min_length[2]|max_length[20]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'education_description' => array(
                            'label'  => lang('create_education_description_label'),
                            'field'  => 'description',
                            'rules'  => 'trim|required|human_name|min_length[2]|max_length[50]|is_unique[educations.education_description]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                    ),
                    'update' => array(
                        'education_code'        => array(
                            'label'  => lang('create_education_code_label'),
                            'field'  => 'code',
                            'rules'  => 'trim|required|is_unique[educations.education_code]|min_length[2]|max_length[20]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'education_description' => array(
                            'label'  => lang('create_education_description_label'),
                            'field'  => 'description',
                            'rules'  => 'trim|required|human_name|min_length[2]|max_length[50]|is_unique[educations.education_description]',
                            'errors' => array(
                                'is_unique' => 'The {field} already exist.'
                            )
                        ),
                        'id'                    => array(
                            'field' => 'id',
                            'label' => 'ID',
                            'rules' => 'trim|is_natural_no_zero|required'
                        ),
                    )
                );
        }

}
