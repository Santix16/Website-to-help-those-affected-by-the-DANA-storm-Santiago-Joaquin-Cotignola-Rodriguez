package com.tuteladana.repository

import com.tuteladana.config.DatabaseConfig
import com.tuteladana.model.ContactMessage

object ContactRepository {
    fun create(message: ContactMessage): Int {
        val sql = "INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql, java.sql.Statement.RETURN_GENERATED_KEYS).use { stmt ->
                stmt.setString(1, message.nombre)
                stmt.setString(2, message.email)
                stmt.setString(3, message.mensaje)
                stmt.executeUpdate()
                val keys = stmt.generatedKeys
                if (keys.next()) {
                    return keys.getInt(1)
                }
            }
        }
        return 0
    }

    fun list(): List<ContactMessage> {
        val messages = mutableListOf<ContactMessage>()
        val sql = "SELECT id, nombre, email, mensaje, fecha_envio FROM contacto ORDER BY fecha_envio DESC"
        DatabaseConfig.getConnection().use { conn ->
            conn.prepareStatement(sql).use { stmt ->
                stmt.executeQuery().use { rs ->
                    while (rs.next()) {
                        messages.add(
                            ContactMessage(
                                id = rs.getInt("id"),
                                nombre = rs.getString("nombre"),
                                email = rs.getString("email"),
                                mensaje = rs.getString("mensaje"),
                                fechaEnvio = rs.getTimestamp("fecha_envio")?.toString()
                            )
                        )
                    }
                }
            }
        }
        return messages
    }
}
