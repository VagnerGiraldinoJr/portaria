<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialValuesTableCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::unprepared("        INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (1,1,0,'0',0,'FLAG','1972-02-17 08:58:56',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (2,1,1,'0',0,'NÃO','1971-08-07 04:38:40',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (3,1,2,'1',0,'SIM','1975-11-07 15:21:24',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (7,3,0,'0',0,'TIPO PRODUTO','1973-09-21 21:59:49',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (8,3,1,'1',0,'PRODUTO','1974-04-04 02:20:00',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (9,3,2,'2',0,'SERVIÇO','1977-06-12 04:21:36',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (10,4,0,'0',0,'UNIDADE MEDIDA','1971-01-25 00:18:24',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (11,4,1,'1',0,'M2','1973-09-21 21:59:48',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (12,4,2,'2',0,'UNIDADE','1972-08-29 13:19:12',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (13,4,3,'3',0,'METRO','1972-08-29 13:19:12',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (14,4,4,'4',0,'HORAS','1977-12-23 08:41:52',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (15,5,0,'0',0,'FORMA_PAGAMENTO','1975-11-07 15:20:52',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (16,5,1,'1',0,'C. CRÉDITO','1975-04-27 11:00:32',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (17,5,2,'2',0,'C. DÉBITO','1974-10-15 06:40:16',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (18,5,3,'3',0,'DEPÓSITO','1974-04-04 02:20:00',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (19,5,4,'4',0,'DINHEIRO','1973-03-11 17:39:32',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (20,5,5,'5',0,'CHEQUE','1976-11-30 00:01:20',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (21,6,0,'0',0,'STATUS_PEDIDO','1976-11-30 00:01:20',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (22,6,1,'1',0,'EM ORÇAMENTO','1976-11-30 00:01:20',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (23,6,2,'2',0,'EM PRODUÇÃO','1975-04-27 11:00:36',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (24,6,3,'3',0,'FINALIZADO','1976-11-30 00:01:20',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (25,7,0,'0',0,'TIPO OPERACAO','1973-09-21 21:59:44',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (26,7,1,'1',1,'ENTRADA','1973-03-11 17:39:28',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (27,7,2,'0',1,'SAÍDA','1982-03-25 19:24:04',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (28,8,0,'0',0,'TIPO_REFERENCIA_ENTRADA_SAIDA','1973-03-11 17:39:28',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (29,8,1,'1',0,'PEDIDO','1973-03-11 17:39:28',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (30,8,2,'2',0,'AVULSO','1981-03-02 10:44:00',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (32,8,3,'3',1,'RETIRADA','1973-09-21 21:59:44',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (33,8,4,'4',1,'EXTORNO','1977-06-12 04:21:36',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (34,10,0,'0',0,'FORMA_RETIRADA','1974-04-04 02:20:00',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (35,10,1,'1',0,'DINHEIRO','1973-03-11 17:39:28',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (36,10,2,'2',0,'CHEQUE','1975-04-28 05:12:48',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (39,7,99,'99',0,'FECHAMENTO','1974-04-04 20:32:16',NULL);
        //                         INSERT INTO `table_codes` (`id`,`pai`,`item`,`valor`,`flag`,`descricao`,`created_at`,`updated_at`) VALUES (40,7,88,'88',0,'ABERTURA','1985-06-02 21:08:32',NULL);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("");
    }
}
