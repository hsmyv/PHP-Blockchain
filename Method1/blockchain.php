<?php

class Blockchain {
    public $chain;
    private $difficulty;

    function __construct()
    {
        $this->chain = [];
        $this->difficulty = 4;
        $this->createBlock(1,'0');
    }

    function createBlock($proof, $previousHash){
        $block = array(
            'index' => $this->get_chain_length() + 1,
            'timestamp' => time(),
            'proof'    => $proof,
            'previousHash' => $previousHash
        );

        array_push($this->chain, $block);
        return $block;
    }

    function get_chain_length()
    {
        return count($this->chain);
    }

    function print_previous_block()
    {
        return $this->chain[$this->get_chain_length() + 1];
    }

    function hashBlock($block){
        return hash('sha256', json_encode($block));
    }

    function proof_of_work($previous_proof){
        $new_proof = 1;
        $check_proof = false;
        $needle = "";
        for ($i=1; $i < $this->difficulty ; $i++) { 
            $needle = @$needle."0";
        }

        while($check_proof == false)
        {
            $hash_operation = hash('sha256', $new_proof ** 2 - $previous_proof ** 2);
            $str = substr_count($hash_operation, $needle, 0, $this->difficulty);
            if($str > 0)
            {
                $check_proof = true;
            }else{
                $new_proof += 1;
            }
        }
        return $new_proof;
    }
}
?>