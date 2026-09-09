package com.tuteladana.repository

import com.tuteladana.config.DatabaseConfig
import com.tuteladana.model.Order

object OrderRepository {
    fun create(order: Order): Int {
        val sql = "INSERT INTO pedidos (usuario_id, estado, total_tonkens) VALUES (?, ?, ?)"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql, java.sql.Statement.RETURN_GENERATED_KEYS).use { stmt ->
                stmt.setInt(1, order.usuarioId)
                stmt.setString(2, order.estado)
                stmt.setInt(3, order.totalTonkens)
                stmt.executeUpdate()
                val keys = stmt.generatedKeys
                if (keys.next()) {
                    return keys.getInt(1)
                }
            }
        }
        return 0
    }

    fun listByUser(userId: Int): List<Order> {
        val orders = mutableListOf<Order>()
        val sql = "SELECT id, usuario_id, estado, total_tonkens, fecha_pedido FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.setInt(1, userId)
                stmt.executeQuery().use { rs ->
                    while (rs.next()) {
                        orders.add(
                            Order(
                                id = rs.getInt("id"),
                                usuarioId = rs.getInt("usuario_id"),
                                estado = rs.getString("estado"),
                                totalTonkens = rs.getInt("total_tonkens"),
                                fechaPedido = rs.getTimestamp("fecha_pedido")?.toString()
                            )
                        )
                    }
                }
            }
        }
        return orders
    }
}
