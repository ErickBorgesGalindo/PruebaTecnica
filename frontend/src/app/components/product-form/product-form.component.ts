import { Component, EventEmitter, Input, Output, OnChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ProductService } from '../../services/product.service';

@Component({
  selector: 'app-product-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './product-form.component.html',
  styleUrl: './product-form.component.scss'
})
export class ProductFormComponent implements OnChanges {

  @Input() productToEdit: any = null;
  @Output() productCreated = new EventEmitter<void>();

  name = '';
  brand = '';
  price: number | null = null;
  errorMessage = '';
  isEditing = false;
  editId:  any = '';

  constructor(private productService: ProductService) {}

  ngOnChanges(): void {
    if (this.productToEdit) {
      this.isEditing = true;
      this.editId = this.productToEdit.id;
      this.name = this.productToEdit.name;
      this.brand = this.productToEdit.brand;
      this.price = this.productToEdit.price;
    } else {
      this.resetForm();
    }
  }

  onSubmit(): void {
    this.errorMessage = '';

    if (!this.name || !this.brand || this.price === null) {
      this.errorMessage = 'Todos los campos son obligatorios';
      return;
    }

    if (this.price > 999) {
      this.errorMessage = 'El precio máximo es 999';
      return;
    }

    const data = {
      name: this.name,
      brand: this.brand,
      price: this.price
    };

    if (this.isEditing) {
      this.productService.updateProduct(this.editId, data).subscribe({
        next: () => {
          this.resetForm();
          this.productCreated.emit();
        },
        error: () => {
          this.errorMessage = 'Error al actualizar el producto';
        }
      });
    } else {
      this.productService.createProduct(data).subscribe({
        next: () => {
          this.resetForm();
          this.productCreated.emit();
        },
        error: () => {
          this.errorMessage = 'Error al crear el producto';
        }
      });
    }
  }

  resetForm(): void {
    this.isEditing = false;
    this.editId = '';
    this.name = '';
    this.brand = '';
    this.price = null;
    this.errorMessage = '';
  }
}