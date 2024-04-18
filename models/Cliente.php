<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 * Criado por Gii
 *
 * @property int $id
 * @property string $nome
 * @property int $cpf
 * @property string $email
 * @property string|null $logradouro
 * @property int|null $num
 * @property int|null $cep
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $complemento
 * @property string|null $foto
 * @property string|null $sexo
 * @property string $created_at
 * @property string|null $updated_at
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'cpf', 'email'], 'required'],
            [['cpf', 'num', 'cep'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nome', 'email', 'logradouro', 'cidade', 'complemento', 'foto'], 'string', 'max' => 255],
            [['uf'], 'string', 'max' => 2],
            [['sexo'], 'string', 'max' => 1],
            [['cpf'], 'unique'],
            [['email'], 'unique'],
			// [['cpf'], 'validarCPF'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome completo',
            'cpf' => 'CPF',
            'email' => 'E-mail',
            'logradouro' => 'Logradouro',
            'num' => 'Número',
            'cep' => 'CEP',
            'cidade' => 'Cidade',
            'uf' => 'Estado',
            'complemento' => 'Complemento',
            'foto' => 'Foto do cliente',
            'sexo' => 'Sexo',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }


	public function validarCPF($attribute, $params)
    {
        $cpf = $this->$attribute;
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            $this->addError($attribute, 'CPF inválido.');
            return;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->addError($attribute, 'CPF inválido.');
            return;
        }

        for ($i = 9, $j = 0, $soma = 0; $i > 0; $i--, $j++) {
            $soma += $cpf[$j] * $i;
        }

        $digito1 = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);

        for ($i = 10, $j = 0, $soma = 0; $i > 0; $i--, $j++) {
            $soma += $cpf[$j] * $i;
        }

        $digito2 = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);

        if ($cpf[9] != $digito1 || $cpf[10] != $digito2) {
            $this->addError($attribute, 'CPF inválido.');
            return;
        }
		
		return ExitCode::OK;
    }

}
