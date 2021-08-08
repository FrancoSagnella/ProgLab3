"use strict";
/// <reference path="./usuario.ts" /> 
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Empleado = /** @class */ (function (_super) {
        __extends(Empleado, _super);
        function Empleado(nombre, correo, clave, id, id_perfil, perfil, sueldo, foto) {
            var _this = 
            //llamo al constructor padre
            _super.call(this, nombre, correo, clave, id, id_perfil, perfil) || this;
            _this.sueldo = sueldo;
            _this.foto = foto;
            return _this;
        }
        Empleado.prototype.ToString = function () {
            return JSON.stringify(this);
        };
        Empleado.prototype.ToJSON = function () {
            return JSON.parse(this.ToString());
        };
        return Empleado;
    }(Entidades.Usuario));
    Entidades.Empleado = Empleado;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=empleado.js.map