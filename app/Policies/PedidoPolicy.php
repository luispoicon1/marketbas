<?php



namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    /**
     * Determina si el usuario puede ver cualquier pedido (no usado aquí).
     */
    public function viewAny(User $user): bool
    {
        return true; // Opcional, si tienes lista de pedidos
    }

    /**
     * Determina si el usuario puede ver un pedido específico.
     */
    public function view(User $user, Pedido $pedido): bool
    {
        // Admin y vendedor pueden ver cualquier pedido
        if (in_array($user->role, ['admin', 'vendedor'])) {
            return true;
        }

        // Comprador solo puede ver sus propios pedidos
        return $pedido->user_id === $user->id;
    }

    /**
     * Permite crear pedido si el usuario está autenticado
     */
    public function create(User $user): bool
    {
        return $user !== null;
    }

    /**
     * Permite actualizar pedido si:
     * - Admin y vendedor pueden actualizar cualquier pedido
     * - Comprador puede actualizar solo sus propios pedidos
     */
    public function update(User $user, Pedido $pedido): bool
    {
        if (in_array($user->role, ['admin', 'vendedor'])) {
            return true;
        }

        return $pedido->user_id === $user->id;
    }

    /**
     * Otras funciones pueden dejarse false o ajustarlas si quieres permitir eliminar, etc.
     */
    public function delete(User $user, Pedido $pedido): bool
    {
        return false;
    }

    public function restore(User $user, Pedido $pedido): bool
    {
        return false;
    }

    public function forceDelete(User $user, Pedido $pedido): bool
    {
        return false;
    }
}
