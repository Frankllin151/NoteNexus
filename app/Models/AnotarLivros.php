<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnotarLivros extends Model
{
    use HasFactory;


    // Definir o nome da tabela
    protected $table = 'anotarlivros';

    // Definir os campos que podem ser atribuídos em massa
    protected $fillable = [
         "id",
        'user_id',
        'nomelivro',
        'capitulo',
        'parent_id',
        'trecho',
    ];

    // Se quiser que o modelo utilize as colunas created_at e updated_at
    public $timestamps = true;

    // Definir os tipos de dados para os campos
    protected $casts = [
        'user_id' => 'integer',
        'parent_id' => 'integer',
    ];

    // Definir a relação com o usuário (se existir uma tabela de usuários)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definir a relação para os comentários do livro (se for um sistema hierárquico)
    public function children()
    {
        return $this->hasMany(AnotarLivros::class, 'parent_id');
    }

    // Definir a relação para o pai do comentário (se for um sistema hierárquico)
    public function parent()
    {
        return $this->belongsTo(AnotarLivros::class, 'parent_id');
    }





    public static function getAllDescendantIds($id)
    {
        $descendants = [];
        
        // Encontrar todos os capítulos que pertencem ao nomelivro
        $chapters = AnotarLivros::where('parent_id', $id)->pluck('id')->toArray();
        
        foreach ($chapters as $chapterId) {
            // Adicionar o capítulo à lista de descendentes
            $descendants[] = $chapterId;

            // Encontrar todos os trechos que pertencem ao capítulo
            $sections = AnotarLivros::where('parent_id', $chapterId)->pluck('id')->toArray();
            
            foreach ($sections as $sectionId) {
                // Adicionar o trecho à lista de descendentes
                $descendants[] = $sectionId;
            }
        }

        return $descendants;
    }




    public static function getTrechosIds($chapterId)
    {
        return AnotarLivros::where('parent_id', $chapterId)->pluck('id')->toArray();
    }
}
