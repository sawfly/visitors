<?php

namespace Sawfly\Visitors;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /**
     * All fields is mass assignable
     * @var array
     */
    protected $fillable = ['ip', 'agent', 'created_at', 'locale'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param array $fields
     * @return int
     */
    public function insert(array $fields = [])
    {
        $data = array_flip($this->fillable);
        foreach ($fields as $field => $value) {
            if (in_array($field, $this->fillable) && $value) {
                $data[$field] = $value;
            }
        }
        foreach ($data as $key => $item) {
            if (is_numeric($item)) {
                switch ($key) {
                    case 'ip':
                        $data[$key] = '127.0.0.1';
                        break;
                    case 'agent':
                        $data[$key] = 'no agent';
                        break;
                    case 'locale':
                        $data[$key] = 'ua';
                        break;
                    default:
                        $data[$key] = Carbon::now()->format('Y-m-d');
                }
            }
        }
        return $this->create($data) ? 1 : 0;
    }
}
