# -*- coding: utf-8 -*-
##############################################################################
#
#    Second Hand Cars module for OpenERP
#    Copyright (C) 2013 Guillaume RIVIERE.
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU Affero General Public License as
#    published by the Free Software Foundation, either version 3 of the
#    License, or (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU Affero General Public License for more details.
#
#    You should have received a copy of the GNU Affero General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
##############################################################################

from openerp.osv import osv
from openerp.osv import fields
from openerp.tools.translate import _
import time

class secondhandcars_brand(osv.osv):
    """ Brand of cars """
    _name = "secondhandcars.brand"
    _description = "Brands of cars"
    _columns = {
        'name': fields.char('Brand name', size=64, required=True),
		'international website': fields.char('International website', size=64, required=True),
		'local website': fields.char('local website', size=64, required=True)
    }
    _sql_constraints = [
        ('name', 'unique(name)', 'The name of the brand must be unique')
    ]


class secondhandcars_model(osv.osv):
    _name = "secondhandcars.model"
    _description = "Models of cars"
    _columns = {
        'name': fields.char('Model name', size=64, required=True),
		'brand_id': fields.many2one('secondhandcars.brand', 'Brand', required=True),
		'last_year': fields.integer('last_year', required=False)
    }
    _sql_constraints = [
        ('name', 'unique(name)', 'The name of the brand must be unique')
    ]


class secondhandcars_car(osv.osv):
    _name = "secondhandcars.car"
    _description = "cars"
    _columns = {
        'create_uid': fields.many2one('res.users', 'Creator', required=True),
        'model_ids': fields.many2one('secondhandcars.model', 'Model', required=True),
        'immatriculation': fields.char('immatriculation code', size=64, required=True),
		'km_in': fields.float('km_in', size=64, required=True),
        'km_out': fields.float('km_out', size=64, required=True),
        'price': fields.float('price', size=64, required=False),
		'doors': fields.integer('doors', size=64, required=True),
        'seats': fields.integer('seats', size=64, required=True),
        'engine':fields.selection([('Gasoline', 'Gasoline'),
            ('Diesel', 'Diesel'),
            ('Gaz', 'Gaz'),
            ('Electricity', 'Electricity'),
            ('Hybrid', 'Hybrid'),
            ],
            'engine',  track_visibility='onchange'),
	'state': fields.selection([('draft', 'New'),
            ('ready', 'ready'),
            ('repaired', 'repaired'),
            ('sold', 'sold'),
            ('cancel', 'cancel')],
            'Status', readonly=True, track_visibility='onchange',
        )
          }

    def secondhandcars_cancel(self, cr, uid, ids, context=None):
        return self.write(cr, uid, ids, {'state': 'cancel'}, context=context)

    def secondhandcars_open(self, cr, uid, ids, context={}):
        return self.write(cr, uid, ids, {'state': 'ready'}, context=context)

    def secondhandcars_close(self, cr, uid, ids, context={}):
        return self.write(cr, uid, ids, {'state': 'repaired'}, context=context)

    def secondhandcars_draft(self, cr, uid, ids, context={}):
        return self.write(cr, uid, ids, {'state': 'draft'}, context=context)

    def secondhandcars_sold(self, cr, uid, ids, context={}):
        return self.write(cr, uid, ids, {'state': 'sold'}, context=context)
