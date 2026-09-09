package com.tuteladana.controller

import com.tuteladana.model.Order
import com.tuteladana.repository.OrderRepository
import io.ktor.http.HttpStatusCode
import io.ktor.server.application.call
import io.ktor.server.request.receive
import io.ktor.server.response.respond
import io.ktor.server.routing.Route
import io.ktor.server.routing.post

object OrderController {
    private val orderRepository = OrderRepository

    fun register(route: Route) {
        route.post("/orders") {
            val order = call.receive<Order>()
            val id = orderRepository.create(order)
            call.respond(HttpStatusCode.Created, mapOf("id" to id, "message" to "Pedido registrado"))
        }
    }
}
