<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AnuncioController extends Controller
{
    /**
     * Verificar propriedade ou permissão administrativa.
     */
    private function autorizar(Anuncio $anuncio): void
    {
        $usuario = auth()->user();

        abort_unless(
            $usuario &&
            (
                $usuario->tipo_usuario === 'administrador' ||
                $anuncio->usuario_id === $usuario->id
            ),
            403,
            'Você não tem permissão para alterar este anúncio.'
        );
    }

    /**
     * Listar anúncios do mural.
     */
    public function index(Request $request)
    {
        $consulta = Anuncio::with(['usuario', 'categoria'])
            ->where(function ($query) {
                $query->where('status', 'ativo')
                    ->orWhere('usuario_id', auth()->id());
            });

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $consulta->where(function ($query) use ($busca) {
                $query->where('titulo', 'like', "%{$busca}%")
                    ->orWhere('descricao', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $consulta->where('categoria_id', $request->categoria_id);
        }

        $anuncios = $consulta
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categorias = Categoria::where('ativa', true)
            ->orderBy('nome')
            ->get();

        return view('anuncios.index', compact(
            'anuncios',
            'categorias'
        ));
    }

    /**
     * Exibir formulário de publicação.
     */
    public function create()
    {
        $categorias = Categoria::where('ativa', true)
            ->orderBy('nome')
            ->get();

        return view('anuncios.create', compact('categorias'));
    }

    /**
     * Publicar anúncio.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'categoria_id' => [
                'required',
                Rule::exists('categorias', 'id')
                    ->where('ativa', true),
            ],
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:3000'],
            'contato' => ['required', 'string', 'max:30'],
            'informacoes_oferta' => ['nullable', 'string', 'max:2000'],
            'imagem' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')
                ->store('anuncios', 'public');
        }

        $dados['usuario_id'] = auth()->id();
        $dados['status'] = 'pendente';

        Anuncio::create($dados);

        return redirect()
            ->route('anuncios.index')
            ->with('success', 'Anúncio enviado para análise!');
    }

    /**
     * Exibir anúncio.
     */
    public function show(Anuncio $anuncio)
    {
        $usuario = auth()->user();

        if (
            $anuncio->status !== 'ativo' &&
            $anuncio->usuario_id !== $usuario->id &&
            $usuario->tipo_usuario !== 'administrador'
        ) {
            abort(404);
        }

        $anuncio->load(['usuario', 'categoria']);

        return view('anuncios.show', compact('anuncio'));
    }

    /**
     * Exibir formulário de edição.
     */
    public function edit(Anuncio $anuncio)
    {
        $this->autorizar($anuncio);

        $categorias = Categoria::where('ativa', true)
            ->orWhere('id', $anuncio->categoria_id)
            ->orderBy('nome')
            ->get();

        return view('anuncios.edit', compact(
            'anuncio',
            'categorias'
        ));
    }

    /**
     * Atualizar anúncio.
     */
    public function update(Request $request, Anuncio $anuncio)
    {
        $this->autorizar($anuncio);

        $dados = $request->validate([
            'categoria_id' => [
                'required',
                Rule::exists('categorias', 'id')
                    ->where(function ($query) use ($anuncio) {
                        $query->where('ativa', true)
                            ->orWhere('id', $anuncio->categoria_id);
                    }),
            ],
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string', 'max:3000'],
            'contato' => ['required', 'string', 'max:30'],
            'informacoes_oferta' => ['nullable', 'string', 'max:2000'],
            'imagem' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('imagem')) {
            if ($anuncio->imagem) {
                Storage::disk('public')->delete($anuncio->imagem);
            }

            $dados['imagem'] = $request->file('imagem')
                ->store('anuncios', 'public');
        }

        // Alterações de conteúdo voltam para análise.
        $dados['status'] = 'pendente';

        $anuncio->update($dados);

        return redirect()
            ->route('anuncios.index')
            ->with('success', 'Anúncio atualizado e enviado para análise!');
    }

    /**
     * Excluir anúncio.
     */
    public function destroy(Anuncio $anuncio)
    {
        $this->autorizar($anuncio);

        if ($anuncio->imagem) {
            Storage::disk('public')->delete($anuncio->imagem);
        }

        $anuncio->delete();

        return redirect()
            ->route('anuncios.index')
            ->with('success', 'Anúncio excluído com sucesso!');
    }
}
