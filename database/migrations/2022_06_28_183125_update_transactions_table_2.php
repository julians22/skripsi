<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('transaction_table_2', 'transactions');

        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('type', 'typeable_type');
            $table->renameColumn('type_id', 'typeable_id');

            $table->string('typeable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
