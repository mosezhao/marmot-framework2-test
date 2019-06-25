<?php
namespace Marmot\Framework\Query;

use Marmot\Framework\Interfaces\DbLayer;

trait RowQueryFindable
{
    abstract protected function getDbLayer() : DbLayer;
    
    abstract protected function getPrimaryKey() : string;

     /**
     * 根据条件查询匹配到条件的id数组
     *
     * @param mix $condition 查询条件
     * @param integer $offset 偏移量
     * @param integer $size 查询数量
     *
     * @return [] 查询到的id数组
     */
    public function find(string $condition, int $offset, int $size)
    {
        if (empty($condition)) {
            $condition = '1';
        }

        if ($size > 0) {
            $condition = $condition.' LIMIT '.$offset.','.$size;
        }
        return $this->getDbLayer()->select($condition, $this->primaryKey);
    }

    /**
     * 根据条件获取查询结果总数
     *
     * @return integer 查询数据总数
     */
    public function count(string $condition)
    {
        $count = $this->getDbLayer()->select($condition, 'COUNT(*) as count');
        return $count[0]['count'];
    }
}
