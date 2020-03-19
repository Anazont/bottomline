<?php

include_once 'BottomlineWrapperBase.php';

class BottomlineWrapper extends BottomLineWrapperBase
{
    /**
     * @var mixed $value
     */
    private $value;

    /**
     * BottomlineWrapper constructor.
     *
     * @param mixed $value the value that is going to be chained
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * dynamically calls bottomline function, prepend the list of parameters with the current collection list
     *
     * @param string $functionName must be a valid bottomline function
     * @param array  $params
     *
     * @throws \BadFunctionCallException
     *
     * @return $this
     */
    public function __call($functionName, $params)
    {
        if (is_callable('__', $functionName)) {
            $params = $params == null ? [] : $params;
            $params = __::prepend($params, $this->value);
            $this->value = call_user_func_array(array('__', $functionName), $params);

            return $this;
        }

        throw new \BadFunctionCallException("Invalid function {$functionName}");
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
