package com.tuteladana.model

import kotlinx.serialization.Serializable

@Serializable
data class Order(
    val id: Int? = null,
    val usuarioId: Int,
    val estado: String = "pendiente",
    val totalTonkens: Int,
    val fechaPedido: String? = null
)
