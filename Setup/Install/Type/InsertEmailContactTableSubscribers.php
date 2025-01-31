<?php

namespace Dotdigitalgroup\Email\Setup\Install\Type;

use Dotdigitalgroup\Email\Setup\Schema;

class InsertEmailContactTableSubscribers extends AbstractDataMigration implements InsertTypeInterface
{
    /**
     * @var string
     */
    protected $tableName = Schema::EMAIL_CONTACT_TABLE;

    /**
     * @inheritdoc
     */
    protected function getSelectStatement()
    {
        return $this->installer
            ->getConnection()
            ->select()
            ->from([
                'subscriber' => $this->installer->getTable('newsletter_subscriber'),
            ], [
                'email' => 'subscriber_email',
                'customer_id' => new \Zend_Db_Expr('0'),
                'is_subscriber' => new \Zend_Db_Expr('1'),
                'subscriber_status' => new \Zend_Db_Expr('1'),
                'store_id',
            ])
            ->where('customer_id = ?', 0)
            ->where('subscriber_status = ?', 1)
            ->order('subscriber_id')
        ;
    }

    /**
     * @inheritdoc
     */
    public function getInsertArray()
    {
        return [
            'email',
            'customer_id',
            'is_subscriber',
            'subscriber_status',
            'store_id',
        ];
    }
}