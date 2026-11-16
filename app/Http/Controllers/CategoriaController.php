<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    /**
     * Verificar se o usuário é administrador.
     */
    private function verificarAdministrador(): void
    {
        abort_unless(
            auth()->user()?->tipo_usuario === 'administrador',
            403,
            'Você não tem permissão para realizar esta ação.'
        );
    }

    /**
     * Listar categorias.
     */
    public function index()
    {
        $consulta = Categoria::query();

        if (auth()->user()?->tipo_usuario !== 'administrador') {
            $consulta->where('ativa', true);
        }

        $categorias = $consulta
            ->withCount(['anuncios', 'servicos'])
            ->orderBy('nome')
            ->paginate(15);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Exibir formulário de criação.
     */
    public function create()
    {
        $this->verificarAdministrador();

        return view('categorias.create');
    }

    /**
     * Salvar nova categoria.
     */
    public function store(Request $request)
    {
        $this->verificarAdministrador();

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:100', 'unique:categorias,nome'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'ativa' => ['required', 'boolean'],
        ]);

        Categoria::create($dados);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria cadastrada com sucesso!');
    }

    /**
     * Exibir uma categoria.
     */
    public function show(Categoria $categoria)
    {
        abort_unless(
            $categoria->ativa || auth()->user()?->tipo_usuario === 'administrador',
            404
        );

        $categoria->loadCount(['anuncios', 'servicos']);

        return view('categorias.show', compact('categoria'));
    }

    /**
     * Exibir formulário de edição.
     */
    public function edit(Categoria $categoria)
    {
        $this->verificarAdministrador();

        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Atualizar categoria.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $this->verificarAdministrador();

        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categorias', 'nome')->ignore($categoria->id),
            ],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'ativa' => ['required', 'boolean'],
        ]);

        $categoria->update($dados);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Excluir categoria.
     */
    public function destroy(Categoria $categoria)
    {
        $this->verificarAdministrador();

        if (
            $categoria->anuncios()->exists() ||
            $categoria->servicos()->exists()
        ) {
            return redirect()
                ->route('categorias.index')
                ->with('erro', 'Esta categoria possui anúncios ou serviços vinculados. Desative-a em vez de excluí-la.');
        }

        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
